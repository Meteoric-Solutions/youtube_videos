# YouTube Videos Block for Moodle

A modern, interactive Moodle block plugin that displays YouTube videos in a beautiful carousel format with search functionality.

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Technical Details](#technical-details)
- [File Structure](#file-structure)
- [Customization](#customization)
- [Troubleshooting](#troubleshooting)
- [License](#license)
- [Support](#support)

## 🎯 Overview

The YouTube Videos block is a Moodle block plugin that allows administrators and teachers to display a curated collection of YouTube videos in an elegant, searchable carousel interface. The block features a modern UI with smooth navigation, real-time search filtering, and responsive design that works seamlessly across all devices.

## ✨ Features

### Core Functionality
- **Video Carousel**: Displays videos in a swipeable carousel format (3 videos per slide)
- **Search Functionality**: Real-time search that filters videos by title and description
- **Video Playback**: Click play button to open YouTube videos in a new tab
- **Multiple Instances**: Support for multiple block instances on the same page
- **Responsive Design**: Fully responsive layout that adapts to mobile, tablet, and desktop screens

### User Interface
- **Modern Design**: Clean, professional interface with custom styling
- **Navigation Controls**: Previous/Next buttons for easy carousel navigation
- **Video Thumbnails**: Custom thumbnail images for each video
- **Play Button Overlay**: Visual play button indicator on each video
- **Search Icon**: Integrated search icon in the search input field

### Technical Features
- **Swiper.js Integration**: Powered by Swiper 11.0.0 for smooth carousel functionality
- **Bootstrap Icons**: Uses Bootstrap Icons 1.11.3 for UI elements
- **AMD JavaScript Module**: Modern JavaScript implementation following Moodle standards
- **Mustache Templates**: Template-based rendering for easy customization
- **Instance-Specific IDs**: Unique identifiers for each block instance to prevent conflicts

## 📦 Requirements

### Moodle Version
- **Minimum**: Moodle 4.0 (2022041900)
- **Recommended**: Moodle 4.0 or higher

### PHP Requirements
- PHP 7.4 or higher (as required by Moodle 4.0)

### Browser Support
- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile browsers (iOS Safari, Chrome Mobile)

### Dependencies
- **Swiper.js**: Version 11.0.0 (included in plugin)
- **Bootstrap Icons**: Version 1.11.3 (included in plugin)
- **jQuery**: Provided by Moodle core

## 🚀 Installation

### Method 1: Manual Installation

1. **Download the Plugin**
   - Download or clone the plugin files
   - Ensure the folder is named `youtube_videos` or `block_youtube_videos`

2. **Upload to Moodle**
   - Navigate to your Moodle installation directory
   - Place the plugin folder in: `moodle/blocks/youtube_videos/`
   - Ensure proper file permissions (755 for directories, 644 for files)

3. **Install via Moodle**
   - Log in as an administrator
   - Navigate to **Site administration** → **Notifications**
   - Follow the installation prompts
   - Click **Upgrade Moodle database now** when prompted

### Method 2: Git Installation

```bash
cd /path/to/moodle/blocks/
git clone [repository-url] youtube_videos
cd youtube_videos
```

Then proceed with the Moodle installation steps above.

### Post-Installation

1. **Purge Caches**
   - Go to **Site administration** → **Development** → **Purge all caches**

2. **Verify Installation**
   - Check **Site administration** → **Plugins** → **Blocks** → **YouTube Videos**
   - Ensure the plugin is listed and enabled

## ⚙️ Configuration

### Adding the Block

1. **Enable Editing Mode**
   - Navigate to any course, site page, or My Moodle page
   - Click **Turn editing on**

2. **Add Block**
   - In the block drawer, click **Add a block**
   - Select **YouTube Videos** from the list

3. **Configure Block Title** (Optional)
   - Click the gear icon on the block
   - Enter a custom title or leave default
   - Click **Save changes**

### Current Configuration

The plugin currently uses **static video data** defined in `block_youtube_videos.php`. To customize videos:

1. **Edit Video Data**
   - Open `block_youtube_videos.php`
   - Locate the `$videosdata` array (lines 61-107)
   - Modify video entries with:
     - `id`: Unique identifier
     - `thumbnail`: Image filename from `pix/` folder
     - `title`: Video title
     - `description`: Video description
     - `url`: Full YouTube URL

2. **Add Thumbnail Images**
   - Place thumbnail images in the `pix/` folder
   - Reference them by filename in the video data array

### Future Configuration Options

The plugin is designed to support:
- Database-driven video management (future enhancement)
- YouTube API integration (future enhancement)
- Admin configuration page (future enhancement)

## 📖 Usage

### For Administrators

1. **Add Block to Site**
   - Add the block to the site homepage for global visibility
   - Configure block title as needed

2. **Manage Videos**
   - Currently, videos are managed by editing the PHP file
   - Future versions will include an admin interface

### For Teachers

1. **Add Block to Course**
   - Add the block to any course page
   - The block will display the configured videos

2. **Student Interaction**
   - Students can browse videos using navigation arrows
   - Students can search for specific videos
   - Clicking play button opens video in new tab

### User Interface Guide

- **Search Bar**: Type to filter videos by title or description
- **Previous/Next Buttons**: Navigate between slides
- **Play Button**: Click to open video in YouTube (new tab)
- **Video Cards**: Display thumbnail, title, and description

## 🔧 Technical Details

### Plugin Structure

- **Component Name**: `block_youtube_videos`
- **Version**: 2024010101 (v1.0)
- **Maturity**: Alpha
- **Release**: v1.0

### Block Class Methods

- `init()`: Initializes the block with default title
- `has_config()`: Returns false (no global configuration)
- `instance_allow_multiple()`: Returns false (one instance per page)
- `applicable_formats()`: Available on site, course, and My Moodle pages
- `get_content()`: Generates block content with video data
- `specialization()`: Handles custom block title configuration

### JavaScript Architecture

- **AMD Module**: `block_youtube_videos/videos`
- **Dependencies**: jQuery, Swiper.js
- **Features**:
  - Swiper instance management per block
  - Search filtering with real-time updates
  - Dynamic slide regeneration
  - Video click handlers

### Template System

- **Template File**: `templates/videos.mustache`
- **Context Variables**:
  - `swiperid`: Unique Swiper container ID
  - `buttonprevclass`: Previous button class
  - `buttonnextclass`: Next button class
  - `searchinputid`: Search input ID
  - `slides`: Array of video slides (3 videos per slide)
  - `videos`: All video data
  - `videosdata`: JSON-encoded video data for JavaScript
  - `imageurls`: URLs for play button and thumbnails

### Styling

- **CSS File**: `styles.css`
- **Color Scheme**:
  - Primary Blue: `#033e87`
  - Background Blue: `#ebf0f5`
  - Text Black: `#000`
  - White: `#fff`
- **Responsive Breakpoints**: Mobile styles at 767px and below

### Third-Party Libraries

1. **Swiper.js 11.0.0**
   - Location: `thirdparty/swiper/`
   - License: MIT
   - Used for: Carousel functionality

2. **Bootstrap Icons 1.11.3**
   - Location: `thirdparty/bootstrap-icons/`
   - License: MIT
   - Used for: UI icons

## 📁 File Structure

```
youtube_videos/
├── amd/
│   └── src/
│       └── videos.js              # Main JavaScript module
├── lang/
│   └── en/
│       └── block_youtube_videos.php  # Language strings
├── pix/
│   ├── Group123.png              # Play button icon
│   ├── Rectangle163.png          # Video thumbnail
│   ├── Rectangle164.png          # Video thumbnail
│   └── Rectangle165.png          # Video thumbnail
├── templates/
│   └── videos.mustache           # Main template
├── thirdparty/
│   ├── bootstrap-icons/
│   │   ├── bootstrap-icons.css
│   │   ├── bootstrap-icons.woff
│   │   └── bootstrap-icons.woff2
│   └── swiper/
│       ├── swiper-bundle.min.css
│       └── swiper-bundle.min.js
├── block_youtube_videos.php      # Main block class
├── styles.css                    # Custom styles
├── thirdpartylibs.xml           # Third-party library definitions
├── version.php                   # Plugin version info
└── README.md                     # This file
```

## 🎨 Customization

### Changing Colors

Edit `styles.css` to modify:
- Primary blue color: `.text-blue` and related classes
- Background colors: `.bg-blue100`, `.bg-white`
- Border colors: Navigation button borders

### Modifying Layout

1. **Videos Per Slide**
   - Edit `block_youtube_videos.php` line 134: `$itemsPerSlide = 3;`
   - Update JavaScript in `videos.js` line 117: `var itemsPerSlide = 3;`

2. **Template Structure**
   - Edit `templates/videos.mustache` to change HTML structure
   - Maintain Mustache variable names for functionality

### Adding Custom Styles

Add custom CSS to `styles.css`:
- Use `.block_youtube_videos_container` as parent selector
- Follow existing naming conventions
- Test responsive behavior

### Language Customization

1. **Add New Language**
   - Create folder: `lang/[langcode]/`
   - Copy `lang/en/block_youtube_videos.php`
   - Translate strings

2. **Modify Existing Strings**
   - Edit `lang/en/block_youtube_videos.php`
   - Available strings:
     - `pluginname`: Block name
     - `search_videos`: Search placeholder
     - `play_video`: Play button tooltip

## 🐛 Troubleshooting

### Block Not Appearing

1. **Check Installation**
   - Verify plugin is in `blocks/youtube_videos/`
   - Check file permissions
   - Purge Moodle caches

2. **Check Block Availability**
   - Ensure block is enabled in **Site administration** → **Plugins** → **Blocks**

### Videos Not Displaying

1. **Check Video Data**
   - Verify video data array in `block_youtube_videos.php`
   - Ensure thumbnail images exist in `pix/` folder
   - Check YouTube URLs are valid

2. **Check JavaScript Console**
   - Open browser developer tools (F12)
   - Check for JavaScript errors
   - Verify Swiper.js is loading

### Search Not Working

1. **Check JavaScript**
   - Verify AMD module is loading
   - Check for jQuery conflicts
   - Ensure search input ID matches

2. **Check Template**
   - Verify search input has correct ID
   - Check Mustache template rendering

### Styling Issues

1. **Clear Browser Cache**
   - Hard refresh (Ctrl+F5 or Cmd+Shift+R)
   - Clear Moodle theme cache

2. **Check CSS Loading**
   - Verify `styles.css` is being loaded
   - Check for CSS conflicts with theme

### Multiple Instance Issues

- Each instance should have unique IDs
- Check browser console for ID conflicts
- Verify instance-specific classes are applied

## 📄 License

This plugin is licensed under the **GNU General Public License v3.0** (GPL-3.0).

### Third-Party Licenses

- **Swiper.js**: MIT License
- **Bootstrap Icons**: MIT License

## 🤝 Support

### Getting Help

1. **Documentation**: Check this README for common issues
2. **Moodle Forums**: Post questions on Moodle.org forums
3. **Issue Tracker**: Report bugs via the plugin's issue tracker (if available)

### Contributing

Contributions are welcome! Areas for improvement:
- Database-driven video management
- YouTube API integration
- Admin configuration interface
- Additional language translations
- Enhanced accessibility features

### Development Status

- **Current Version**: 1.0 (Alpha)
- **Stability**: Alpha - Suitable for testing
- **Future Plans**:
  - Database integration
  - Admin interface
  - YouTube API support
  - Enhanced search features
  - Video categories/tags

## 📝 Changelog

### Version 1.0 (2024-01-01)
- Initial release
- Basic carousel functionality
- Search feature
- Static video data
- Responsive design
- Multiple instance support

## 🔗 Related Resources

- [Moodle Block Development](https://docs.moodle.org/dev/Blocks)
- [Swiper.js Documentation](https://swiperjs.com/)
- [Bootstrap Icons](https://icons.getbootstrap.com/)
- [Moodle Mustache Templates](https://docs.moodle.org/dev/Templates)

