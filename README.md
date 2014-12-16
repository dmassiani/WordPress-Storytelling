Story Telling for WordPress
==========
v 1.1

## the_story()
Storytelling inject multi content where you need.

You can design structured macro-content template, you can choose any anywhere.

## How to use?
- Install Plugin first (git clone or download this)
- Active Storytelling plugin
- Make "storytelling" folder in your theme
- Design macro-template **see section Storytelling Template**
- Add **the_story()** in your template

### In admin
- Design new page or post
- Choose Template in sidebar
- Design beautiful story

## Storytelling Template

### Data needed

In your macro-template, Storytelling must-read 3 important data.

Template Name - Description - Elements

Storytelling use WordPress reading data like :

```php
/*
Template: Macrocontent A
Description: Description for your customers
{"type": "image", "name": "Left Image", "slug": "left_image"}
*/
```

#### Template Name

Used by sidebar metabox

#### Description

Description is used by your customers (if needed)

#### Structured element

Element is the most important chapter you need to know.

Is is really important your think about your structured macro-template before.

Today, Storytelling don't have capability to manage content resulting to element removed or modified from macro-template.

Capability available in a future release.

You have content with macro-template linked? Don't touch macro template used.

Settings an element like that :

```php
{"type": "editor", "name": "Left content", "slug": "left_content"}
```

Elements need 3 data : type, name and slug

Available type : title, editor and image

You can define much element you want

```php
{"type": "editor", "name": "left content", "slug": "left_content"}
{"type": "editor", "name": "center content", "slug": "center_content"}
{"type": "editor", "name": "right content", "slug": "right_content"}
```

Name is display in admin, before editor or image.

slug is for extract right data in right place **see section the_chapter()**

**you can found an example in story-telling/front/macro-template-example.php**

## Roadmap
#### 1.1 : New content : title - done
#### A : Storytelling Website
#### 1.2 : Templates in storytelling plugins
#### 1.3 : Selector between Storytelling Template or Custom Template (in theme)
#### 1.4 : Settings page
#### 1.5 : CSS Storytelling grid (responsive grid for Storyteeling templates)
#### 1.6 : Options available since selctor metabox ( css : on/off, storytelling available : on/off )