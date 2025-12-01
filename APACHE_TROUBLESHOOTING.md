# Apache/XAMPP Server Troubleshooting Guide

## Issue: Page not updating on Apache server but works locally

### Quick Fixes to Try:

#### 1. **Clear Browser Cache**

- **Chrome/Edge:** Press `Ctrl + Shift + Delete`, select "Cached images and files", clear data
- **Firefox:** Press `Ctrl + Shift + Delete`, select "Cache", clear data
- **Or use Hard Refresh:** `Ctrl + F5` or `Ctrl + Shift + R`

#### 2. **Restart Apache in XAMPP Control Panel**

1.  Open XAMPP Control Panel
2.  Click "Stop" next to Apache
3.  Wait 5 seconds
4.  Click "Start" next to Apache
5.  Check if the green "Running" indicator appears

#### 3. **Check File Paths**

- Verify you're accessing: `http://localhost/tokyo-bloom/pages/index.html`
- NOT: `file:///C:/xampp/htdocs/tokyo-bloom/pages/index.html`

#### 4. **Disable Browser Cache (for testing)**

- Chrome DevTools: `F12` → Network tab → Check "Disable cache"
- Keep DevTools open while testing

#### 5. **Check Apache Error Log**

Location: `C:\xampp\apache\logs\error.log`

- Look for recent errors
- Check for file permission issues

#### 6. **Verify File Permissions**

- Ensure your files aren't read-only
- Right-click `tokyo-bloom` folder → Properties → Uncheck "Read-only" if checked

#### 7. **Check Port Conflicts**

- Apache default port: 80
- If port 80 is in use, Apache won't start properly
- In XAMPP Control Panel, click "Netstat" to check port usage

#### 8. **Clear PHP OpCache (if applicable)**

Add to a PHP file temporarily:

```php
<?php
opcache_reset();
echo "Cache cleared!";
?>
```

#### 9. **Check .htaccess Issues**

- If you have a `.htaccess` file, temporarily rename it to `.htaccess.bak`
- Test if the site works

#### 10. **Restart Computer**

- Sometimes Windows services need a full restart

---

## Common Causes:

### Browser Cache

**Most Common Issue!** Modern browsers aggressively cache CSS, JS, and HTML.

### Apache Not Running

Check XAMPP Control Panel - Apache should show green "Running" status.

### Wrong URL

Make sure you're using `http://localhost/` not `file:///`

### Port Conflicts

Skype, IIS, or other services might be using port 80.

### File Permissions

Windows security might be blocking file access.

---

## Testing Checklist:

- [ ] Hard refresh browser (`Ctrl + F5`)
- [ ] Apache is running (green in XAMPP)
- [ ] Using `localhost` URL
- [ ] Disable cache in DevTools
- [ ] Restart Apache
- [ ] Clear browser cache completely
- [ ] Try different browser (Edge, Firefox, Chrome)
- [ ] Check if other PHP files work
- [ ] Restart XAMPP completely

---

## Still Not Working?

1. **Test with a simple file:**
   Create `C:\xampp\htdocs\test.html`:

   ```html
   <!DOCTYPE html>
   <html>
     <head>
       <title>Test</title>
     </head>
     <body>
       <h1>
         Test Page -
         <?php echo date('H:i:s'); ?>
       </h1>
     </body>
   </html>
   ```

   Access: `http://localhost/test.html`

2. **Check XAMPP Apache logs:**

   - Access log: `C:\xampp\apache\logs\access.log`
   - Error log: `C:\xampp\apache\logs\error.log`

3. **Verify PHP is working:**
   Create `C:\xampp\htdocs\info.php`:
   ```php
   <?php phpinfo(); ?>
   ```
   Access: `http://localhost/info.php`

---

## Prevention Tips:

- Always use Hard Refresh when testing changes
- Keep DevTools open with cache disabled during development
- Consider using incognito/private browsing for testing
- Add version query strings to CSS/JS: `style.css?v=2`

---

**Your Changes Are Live!** The updates you made are saved. The issue is likely just browser caching.
