# Latest WordPress posts - a small plugin

This is the GitHub repository for a small WordPress plugin I had to write as an allowance test for my internship at [Green Bananas](https://www.greenbananas.be/).

This plugin loads the 10 latest WordPress blogpost sorted from new to old with a few extra options.

## Inhoudsopgave

> - [Creator](#creator)
> - [Installation](#installation)
> - [Compatibility](#compatibility)
> - [Usage](#usage)
> - [Examples](#examples)
> - [Download](#download)
> - [Modifying the plugin](#modifying-the-plugin)
> - [Sources](#sources)

## Creator

| Name     | GitHub                        | E-mail                               |
| :---     | :---                          | :---                                |
| Lennert Bontinck | <https://github.com/pikawika> | [info@lennertbontinck.com](mailto:info@lennertbontinck.com) |

## Installation

> Coming soon

## Compatibility

This plugin was created for and tested with WordPress 4.9.8 and MariaDB 10.1.36 ran localy on a Windows 10 environment using XAMPP.

> - I used the default WordPress theme "Twenty Seventeen" and created 17 sample posts as dummy data.
> - Every post should have a title, description and a featured image.
> - I used the default "sample-page" to insert my shortcode and test the plugin.
> - I made the page layout One Column (setting under Theme Options).

Hence to the simplicity of this plugin it should work on older and newer versions of WordPress (online and/or offline) and any theme or page without a problem!


## Usage

To use this plugin one can simply insert [simpleLatestPosts] anywhere they like the posts to be displayed. This will use the default settings being:

> - Load the latest 10 posts initially
> - English text
> - load 5 more posts after clicking load more button

To edit these defaults simply specify what you want them replaced with (you can skip those who you wish not to change)

> - readMoreText
>    - String -> Text that should be displayed in the read more button
> - loadMoreText
>    - String -> Text that should be displayed in the load more button
> - initialAmountOfPosts
>    - Integer -> Amount of posts that should initially be loaded
> - amountOfMorePostsToLoad
>    - Integer -> Amount of posts to add to the current list after clicking the load more button

Your shortcode should look something like this

```
[simpleLatestPosts readMoreText='Lees Meer' loadMoreText='Laad meer' initialAmountOfPosts=5 amountOfMorePostsToLoad=5]
```

## Examples

Code to load 5 initial posts and add 5 after each load more click with custom text. The displayed text is now dutch.
```
[simpleLatestPosts readMoreText='Lees Meer' loadMoreText='Laad meer' initialAmountOfPosts=5 amountOfMorePostsToLoad=5]
```

## Modifying the plugin

This plugin is completely open sources and can be modified to your hearts desire. I but some comments in my code so it's easier to read and modify. 

## Sources

The following sources were used to make this plugin.

> - Info about layout of PHP file containing package information
>    - https://www.dreamhost.com/blog/how-to-create-your-first-wordpress-plugin/
> - Info about shortcode good practices
>    - https://codex.wordpress.org/Shortcode_API
> - Info about wp_query
>    - https://codex.wordpress.org/Class_Reference/WP_Query
