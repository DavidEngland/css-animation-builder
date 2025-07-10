# Security Policy

## Supported Versions

We actively support the following versions with security updates:

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | :white_check_mark: |
| < 1.0   | :x:                |

## Reporting a Vulnerability

We take security vulnerabilities seriously. If you discover a security vulnerability, please follow these steps:

### 1. **DO NOT** open a public GitHub issue

Security vulnerabilities should be reported privately to protect users.

### 2. Send a detailed report to: david@realtors.com

Include the following information:
- Description of the vulnerability
- Steps to reproduce the issue
- Potential impact
- Suggested fix (if you have one)
- Your contact information

### 3. Response Timeline

- **Acknowledgment**: Within 48 hours
- **Initial Assessment**: Within 5 business days
- **Status Updates**: Weekly until resolved
- **Fix Timeline**: Depends on severity
  - Critical: Within 7 days
  - High: Within 14 days
  - Medium: Within 30 days
  - Low: Next regular release

### 4. Disclosure Process

1. **Private Report**: You report the vulnerability privately
2. **Acknowledgment**: We acknowledge receipt and begin investigation
3. **Fix Development**: We develop and test a fix
4. **Coordinated Disclosure**: We work with you on disclosure timeline
5. **Public Release**: Fix is released with security advisory
6. **Recognition**: You receive credit (if desired) for responsible disclosure

## Security Best Practices

When using CSS Animation Builder:

### For Developers
- **Keep dependencies updated**
- **Validate all user inputs**
- **Use Content Security Policy (CSP)**
- **Sanitize generated CSS output**
- **Test in various environments**

### For WordPress Users
- **Keep WordPress core updated**
- **Use the latest plugin version**
- **Limit animation builder access** to trusted users
- **Monitor for unusual activity**

### For Standalone Users
- **Validate generated CSS** before production use
- **Implement proper input sanitization**
- **Use HTTPS in production**
- **Monitor for XSS vulnerabilities**

## Known Security Considerations

### CSS Injection Prevention
- All user inputs are sanitized
- Generated CSS is validated
- Dangerous CSS properties are filtered

### XSS Prevention
- All dynamic content is escaped
- User-provided animation names are sanitized
- Generated HTML is validated

### WordPress Security
- Proper capability checks
- Nonce verification for AJAX requests
- Sanitized database interactions

## Security-Related Configuration

### Content Security Policy (CSP)
```http
Content-Security-Policy: style-src 'self' 'unsafe-inline';
```

### WordPress Security Headers
```php
add_action('send_headers', function() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
});
```

## Acknowledgments

We thank the security researchers and community members who help keep CSS Animation Builder secure:

- [Security Contributors will be listed here]

## Contact

For security-related questions or concerns:
- **Email**: david@realtors.com
- **Subject**: [SECURITY] CSS Animation Builder
- **Response Time**: Within 48 hours

Thank you for helping keep CSS Animation Builder secure! 🔒