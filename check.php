<?php
session_start();

// Function to check domain availability using Whois API
function checkDomainAvailability($domain) {
    $domain = $domain . '.com';
    
    // Method 1: Using Whois JSON API (free)
    $url = "https://api.whois.vu/?domain=" . urlencode($domain);
    
    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Domain Checker App)');
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200 && $response) {
        $data = json_decode($response, true);
        
        if (isset($data['available'])) {
            return $data['available'] ? 'available' : 'taken';
        }
    }
    
    // Method 2: Fallback - Check via DNS lookup
    return checkDomainViaDNS($domain);
}

// Fallback method using DNS lookup
function checkDomainViaDNS($domain) {
    // Check if domain has DNS records
    $ip = gethostbyname($domain);
    
    // If the IP is different from the domain, it's likely registered
    if ($ip !== $domain) {
        return 'taken';
    }
    
    // Additional check with checkdnsrr
    if (checkdnsrr($domain, 'ANY')) {
        return 'taken';
    }
    
    return 'available';
}

// Function to store recent checks in session
function storeRecentCheck($domain, $available) {
    if (!isset($_SESSION['recent_checks'])) {
        $_SESSION['recent_checks'] = [];
    }
    
    // Add new check to beginning of array
    array_unshift($_SESSION['recent_checks'], [
        'domain' => $domain,
        'available' => $available,
        'timestamp' => time()
    ]);
    
    // Keep only last 10 checks
    $_SESSION['recent_checks'] = array_slice($_SESSION['recent_checks'], 0, 10);
}

// Main processing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['domain'])) {
    $domain = trim($_POST['domain']);
    
    // Validate domain input
    if (empty($domain) || !preg_match('/^[a-zA-Z0-9-]+$/', $domain)) {
        header('Location: index.php?result=error&domain=' . urlencode($domain));
        exit;
    }
    
    // Clean the domain input
    $domain = preg_replace('/[^a-zA-Z0-9-]/', '', $domain);
    
    // Check domain availability
    $result = checkDomainAvailability($domain);
    
    // Store in session for recent checks
    storeRecentCheck($domain, $result === 'available');
    
    // Redirect back with results
    header('Location: index.php?result=' . $result . '&domain=' . urlencode($domain));
    exit;
} else {
    // Invalid request, redirect to home
    header('Location: index.php');
    exit;
}
?>