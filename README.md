# 🌐 Domain Availability Checker

![Domain Checker Preview](https://i.postimg.cc/rFT5qsNF/domain-checker.jpg)
*Replace with actual screenshot of your application*

A sleek PHP application to check domain name availability in real-time using WHOIS API with Bootstrap 4 interface.

## ✨ Features

- ✅ **Real-time Domain Checking** - WHOIS API integration
- 🎨 **Beautiful Bootstrap 4 UI** - Fully responsive design
- 🔄 **Fallback System** - DNS lookup if API fails
- 📱 **Recent History** - Track last 10 checked domains
- 🛡️ **Input Validation** - Client & server-side security
- 🚀 **No API Key Required** - Free WHOIS service

## 🚀 Quick Start

### Requirements
- PHP 7.0+
- cURL extension
- Web server

### Installation
```bash
git clone https://github.com/yourusername/domain-checker.git
cd domain-checker
# Upload to your web server
```

### Usage
1. Enter domain name (without extension)
2. Click "Check Availability"
3. View instant results
4. Check recent history below

## 📁 File Structure
```
domain-checker/
├── index.php          # Main interface
├── check.php          # Domain logic
├── style.css          # Custom styles
└── README.md
```

## 🛠️ How It Works

**Primary Method**: WHOIS API (`api.whois.vu`)
```php
$result = checkDomainAvailability($domain);
```

**Fallback**: DNS lookup
```php
$ip = gethostbyname($domain . '.com');
```

## 🔧 Configuration

**Change TLD** (in `check.php`):
```php
$domain = $domain . '.com'; // Change to .net, .org, etc.
```

## 📸 Screenshots

![Main Interface](https://i.postimg.cc/bY5NRBdW/domain-checker-empty.png)
*Clean, modern interface*

![Results](https://i.postimg.cc/rFT5qsNF/domain-checker.jpg)
*Instant availability results*

## 🐛 Troubleshooting

**Common Issues:**
- "API Error" → Check internet connection
- Slow response → API might be busy
- Sessions not working → Verify PHP session config

**Debug Mode:**
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 🤝 Contributing

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

MIT License - see [LICENSE](LICENSE) file for details.

## 🌐 Live Demo

[View Live Demo]([https://yourdomain.com/domain-checker](https://i.postimg.cc/rFT5qsNF/domain-checker.jpg)

---

<div align="center">

**Built with ❤️ using PHP & Bootstrap**

*For personal and educational use*

</div>

---
