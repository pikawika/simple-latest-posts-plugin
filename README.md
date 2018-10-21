# Latest WordPress posts - a small plugin

This is the GitHub repository for a small WordPress plugin I had to write as an allowance test for my internship at [Green Bananas](https://www.greenbananas.be/).

This plugin loads the 6 (editable) latest WordPress blogpost sorted from new to old with the option to load more posts.

## Table of contents

> - [Creator](#creator)
> - [Installation](#installation)
> - [Compatibility](#compatibility)
> - [Usage](#usage)
> - [Examples](#examples)
> - [Modifying the plugin](#modifying-the-plugin)
> - [Download](#download)
> - [Sources](#sources)

## Creator

| Name     | GitHub                        | E-mail                               |
| :---     | :---                          | :---                                |
| Lennert Bontinck | <https://github.com/pikawika> | [info@lennertbontinck.com](mailto:info@lennertbontinck.com) |

## Installation

> 1. [Download the latest zip](http://lennertbontinck.com/ftp/wp/simpleLatestPosts-Lennert.zip)
> 2. Open your WordPress admin panel
> 3. Go to the plugins tab
> 4. Click "Add New"
> 5. Select upload plugin
> 6. Choose the file you just download -> "simpleLatestPosts-Lennert.zip"
> 7. Click "Install Now"
> 8. Installation should succeed and you should be able to activate the plugin!
> 9. [Usage instructions](#usage)


## Compatibility

This plugin was created for and tested with WordPress 4.9.8 and MariaDB 10.1.36 ran localy on a Windows 10 environment using XAMPP.

> - I used the default WordPress theme "Twenty Seventeen" and created 7 sample posts as dummy data.
> - Every post should have a title, description and a featured image.
> - I used the default "sample-page" to insert my shortcode and test the plugin.
> - I made the page layout One Column (setting under Theme Options).

Hence to the simplicity of this plugin it should work on older and newer versions of WordPress (online and/or offline) and any theme or page without a problem!


## Usage

To use this plugin one can simply insert [simple_latest_posts] anywhere they like the posts to be displayed. This will use the default settings being:

> - Load the latest 10 posts initially
> - English text
> - load 5 more posts after clicking load more button

To edit these defaults simply specify what you want them replaced with (you can skip those who you wish not to change)

> - read_more_text
>    - String -> Text that should be displayed in the read more button
>    - eg: 'Lees meer'
> - load_more_text
>    - String -> Text that should be displayed in the load more button
>    - eg: 'Laad meer'
> - initial_amount_of_posts
>    - Integer -> Amount of posts that should initially be loaded
>    - eg: 3
> - load_more_amount
>    - Integer -> Amount of posts that should be loaded after clicking load more
>    - eg: 6


Your shortcode, in the longest form, should look something like this

```
[simpleLatestPosts read_more_text='Lees meer' load_more_text='Laad meer' initialAmountOfPosts=3  load_more_amount=6]
```

## Examples
Default
```
[simple_latest_posts]
```
<img src="/assets/default.gif" height="500" />

Default with the exception to load 3 initial posts instead of 6.
```
[simple_latest_posts initial_amount_of_posts=3]
```
<img src="/assets/init3.gif" height="500" />

Code to load 3 initial posts and 6 more after clicking load more with custom text. The displayed text is now dutch.
```
[simple_latest_posts initial_amount_of_posts=3 load_more_amount=6 read_more_text='Lees Meer' load_more_text='Laad meer']
```
<img src="/assets/custom.gif" height="500" />

## Modifying the plugin

This plugin is completely open sources and can be modified to your hearts desire. I've put some comments in my code so it's easier to read and modify. 

## Download

> You can download the latest .zip version [here](http://lennertbontinck.com/ftp/wp/simpleLatestPosts-Lennert.zip)

## Sources

The following sources were used to make this plugin.

> - Info about layout of PHP file containing package information
>    - https://www.dreamhost.com/blog/how-to-create-your-first-wordpress-plugin/
> - Info about shortcode good practices
>    - https://codex.wordpress.org/Shortcode_API
> - Info about wp_query
>    - https://codex.wordpress.org/Class_Reference/WP_Query
> - Info about custom css
>    - https://www.dummies.com/web-design-development/wordpress/enhance-wordpress-plugins-css-javascript/
> - Naming conventions
>    - https://codex.wordpress.org/WordPress_Coding_Standards
> - Css inspiration
>    - https://www.lennertbontinck.com/ (and my other projects)
> - Ajax
>    - https://pippinsplugins.com/process-ajax-requests-correctly-in-wordpress-plugins/
