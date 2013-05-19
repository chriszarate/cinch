# Cinch

Use Cinch to make a simple Web site, like [this one](http://chris.zarate.org). It expects you to know what you are doing a little bit.

### Key features

* DIY home page
* Simple page templating
* Use Markdown, HTML, or PHP
* Caching

### Intentionally missing features

* Page editor, “dashboard”
* Most stuff you might think of

### In other words

A blog? No. Install WordPress? No thanks. You know how to use a text editor and upload files, but a simple page template and some caching would be nice. Most of the time [Markdown](http://daringfireball.net/projects/markdown/) is enough, but occasionally you need to do something simple in PHP or HTML. It's 2012, this should be easy.

### How to use it

Cinch does not auto-generate your home page; you provide your own `index.html` (or `index.php`).

Create a new page by creating a file in the `content` directory.

* `.txt` files will be formatted by [Markdown](http://daringfireball.net/projects/markdown/) and [Smartypants](http://daringfireball.net/projects/smartypants/)
* `.html` files will be unaltered
* `.php` files will be included as PHP code

Use the basename of the file (e.g., "cinch" for "cinch.txt") to access your page.

If you have additions to the `<head>` element for a single page, put them in a sidecar file with a `.head` extension:

	cinch.txt
	cinch.head

### Installation

**[Download “Cinch”](https://github.com/chriszarate/cinch)** at Github.

1. Grant PHP write access to the `cache` directory.
2. Review `.htaccess`. It may be necessary to make changes.
3. Load your home page and follow the links to the documentation.

### Future plans

* Syndication support, maybe

### License

This is free software. It is released to the public domain without warranty.
