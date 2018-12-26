# Cadmus

Cadmus is an extremely lightweight, flat-file blogging platform powered by Markdown.

## Features

* Responsive design by default
* Full-Text Search Support (see notes below)
* Flat-file structure (no need for a database)
* Custom Metadata Handling
* Uses a stripped down version of Bootstrap and only includes:
	* Grid System
	* Typography
	* Form Controls
	* Resets
* Markdown support via Parsedown + ParsedownExtra
* Can be deployed anywhere where PHP is supported
* Supports PHP 5.4 and above (including PHP 7.x)
* Does not use a framework, extremely lightweight
* Easy content backup (all data in one folder)
* Disqus comment system integration
* No fancy admin panels
    * Upload posts via any file manager
    * Update Cadmus by overwriting system files
    * No complicated user management system
    * Customize by editing the files directly: no theme setup required!

## Deployment

Just [download the latest release](https://github.com/liamdemafelix/cadmus/releases/latest) and extract it to your public folder. Then in the folder where you extracted the archive, create a `content` folder. This should be writable by the web server. For most cPanel-based hosts, `0755` is enough, but consult your provider if you are not sure.

Your `content` folder contains all your posts.

## Writing

A post is a file in the `content` folder. Files here follow a format:

* Files that end in `.1.txt` are published and visible in searches and on the index page. Example: `filename.1.txt`.
* Files that do not end in `.1.txt` will not be shown on any page. Useful for drafts.

A post consists of two parts: the **metadata** and your **content**. A sample post is as follows:

```
---
Title: A Sample Post
Author: Liam Demafelix
---

Lorem ipsum dolor amet and what not.
```

Your **metadata** defines the various characteristics of your post. Currently, the system requires two metadata values:

* Title
* Author

You can add any other metadata you want, just make sure it follows the format `Identifier: Value`. You can retrieve the value of a metadata using `get_meta($file, $identifier)`. For instance, to pull the title, it's `echo get_meta("./content/test.1.txt", "Title");`.

An optional metadata tag, `Excerpt` is used when displaying contents in post listings when present. Otherwise, Cadmus takes the first 150 characters of your post and adds an ellipsis to it.

The optional `Date` metadata is a non-formatted string (direct output). If it is not defined, the system takes the latest modification time of the file via `filemtime()`.

## Full-Text Search

Currently, the search mechanism scans each file for the presence of a queried term. Of course, this doesn't scale well, but for a few posts it should work out fine. For reference, see `partials/home.php` and the `in_file()` function in `functions.php`.

## License

Cadmus (and its components which are in no relation to and do not endorse the project) is licensed under the MIT Open Source License. Please see [LICENSE.md](https://github.com/liamdemafelix/cadmus/blob/master/LICENSE.md) for more information.