# 🚀 Navbar Styling Quick Reference

## CSS Classes

```css
.header                    /* Main header container */
.header::before           /* Decorative pseudo-element */
.header-left             /* Left content (icon + title) */
.header-icon             /* Icon container */
.header-title            /* Title text container */
.header-title h3         /* Main title */
.header-title small      /* Subtitle */
.header-right            /* Right content (buttons + avatar) */
.avatar                  /* User avatar */
.change-dashboard-btn    /* Switch dashboard button */
.logout-btn              /* Logout button */
```

---

## Key Styling Properties

### Header
```css
background: linear-gradient(135deg, #4A90E2 0%, #6BA4EC 100%);
padding: 20px 40px;
display: flex;
justify-content: space-between;
align-items: center;
box-shadow: 0 2px 12px rgba(74,144,226,0.15);
border-bottom: 1px solid rgba(255,255,255,0.15);
```

### Buttons
```css
padding: 10px 22px;
border-radius: 28px;
background: rgba(255,255,255,.18) /* or .22 for logout */
backdrop-filter: blur(10px);
transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
```

### Avatar
```css
width: 44px;
height: 44px;
border-radius: 50%;
background: linear-gradient(135deg, #FFFFFF 0%, #F0F8FF 100%);
color: #4A90E2;
```

---

## Responsive Adjustments

### Desktop (>992px)
```css
.header { padding: 20px 40px; }
.header-title h3 { font-size: 19px; }
.header-title small { font-size: 13px; }
.avatar { width: 44px; height: 44px; }
```

### Laptop (768-991px)
```css
.header { padding: 16px 28px; }
.header-title h3 { font-size: 17px; }
.avatar { width: 42px; height: 42px; }
```

### Tablet (576-767px)
```css
.header { padding: 14px 20px; }
.header-title h3 { font-size: 15px; }
.header-title small { font-size: 11px; }
.avatar { width: 38px; height: 38px; }
```

### Mobile (<576px)
```css
.header { padding: 12px 14px; }
.header-icon { width: 40px; height: 40px; }
.header-title h3 { font-size: 14px; }
.header-title small { display: none; }
.avatar { width: 36px; height: 36px; }
```

---

## Emoji Icons

| Emoji | Usage | Unicode |
|-------|-------|---------|
| 🚀 | Header icon | U+1F680 |
| ✨ | Subtitle decoration | U+2728 |
| 🔄 | Change dashboard | U+1F504 |
| 🚪 | Logout button | U+1F6AA |

---

## HTML Structure

```html
<div class="header">
    <div class="header-left">
        <div class="header-icon">🚀</div>
        <div class="header-title">
            <h3>Dashboard Operasional</h3>
            <small>Kelola Bisnis yang Sudah Berjalan</small>
        </div>
    </div>
    <div class="header-right">
        <a href="..." class="change-dashboard-btn">🔄 Perencanaan</a>
        <div class="avatar">U</div>
        <a href="..." class="logout-btn">Logout</a>
    </div>
</div>
```

---

## Hover Effects

### Avatar
```css
.avatar:hover {
    transform: scale(1.08) rotate(5deg);
    box-shadow: 0 5px 15px rgba(0,0,0,0.18);
}
```

### Buttons
```css
.change-dashboard-btn:hover,
.logout-btn:hover {
    background: rgba(255,255,255,.32 or .35);
    border-color: rgba(255,255,255,0.55);
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(0,0,0,0.15);
}
```

---

## Color Reference

| Color | Hex | Usage |
|-------|-----|-------|
| Primary | #4A90E2 | Header bg, Avatar text |
| Primary Light | #6BA4EC | Header gradient end |
| White | #FFFFFF | Text, Avatar bg |
| Light Blue | #F0F8FF | Avatar gradient end |
| Shadow | rgba(74,144,226,0.15) | Drop shadow |

---

## Browser Support

- ✅ Chrome 88+
- ✅ Firefox 87+
- ✅ Safari 14+
- ✅ Edge 88+
- ✅ iOS Safari 14+
- ✅ Chrome Mobile 88+

---

## Tips & Best Practices

1. **Always use flexbox** for alignment consistency
2. **Use CSS variables** for color changes (recommended)
3. **Test on actual devices** for mobile experience
4. **Use transition** for smooth hover effects
5. **Optimize images** if adding background images
6. **Check backdrop filter support** for older browsers

---

## Common Modifications

### Change Primary Color
```css
/* Change gradient colors */
.header {
    background: linear-gradient(135deg, #COLOR1 0%, #COLOR2 100%);
}

/* Change avatar color */
.avatar {
    color: #COLOR;
}
```

### Change Font Size
```css
.header-title h3 {
    font-size: NEW_SIZE;
}
```

### Change Button Opacity
```css
.change-dashboard-btn {
    background: rgba(255,255,255,.NEW_VALUE);
}
```

### Change Animation Speed
```css
.avatar,
.change-dashboard-btn,
.logout-btn {
    transition: all NEW_SPEED;
}
```

---

## Troubleshooting

### Gradient not showing
- Check browser support for linear-gradient
- Verify gradient syntax is correct
- Try adding `-webkit-` prefix for older browsers

### Blur effect not working
- Ensure `backdrop-filter` is supported (Chrome 76+)
- Add `-webkit-` prefix: `-webkit-backdrop-filter: blur(10px);`
- Fallback: use regular `background` if needed

### Avatar not circular
- Verify `border-radius: 50%;` is applied
- Check width equals height

### Text overflowing on mobile
- Check responsive font sizes
- Verify `white-space: nowrap;` and `overflow: hidden;`
- Use `text-overflow: ellipsis;` for truncation

---

## Performance Tips

1. Use CSS transforms for animations (GPU accelerated)
2. Avoid changing `box-shadow` on hover (use `filter` instead)
3. Minimize CSS specificity
4. Use `will-change` for optimized animations
5. Avoid excessive pseudo-elements

---

**Last Updated:** January 20, 2025  
**Version:** 1.0
