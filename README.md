# Easy Video Transcripts

## Introduction

A Gutenberg block to embed videos and show their transcripts.

This plugin is still under development.

## How to use

### Set up

1. Download the plugin from Github. Click on the green "Code" button -> Download Zip
1. Extract files and move all the files in one folder to your WP plugins folder
1. Activate plugin
1. Get an API key for "Subtitles for YouTube" here (there is a generous free tier): https://rapidapi.com/yashagarwal/api/subtitles-for-youtube
1. In your WordPress admin, go to Easy Video Transcripts -> Settings, add your API from the previous step in X-RapidAPI-Key, and Save Changes

### Add a Video to Admin

1. In your WordPress admin, go to Easy Video Transcripts > Add New
1. Type in your Title and paste in the link of a Youtube Video under Link Information
1. Click on "Get Transcript". The Rapid API will download the transcript from Youtube if available or generate a new transcript if needed
1. Click on Publish

### Add a Video to a post/page

1. Add a new post/page or edit an existing one - make sure you are using the standard WordPress editor that uses Gutenberg blocks (compatibility with page builders is on the roadmap)
1. Add the Easy Video Transcripts block to your content
1. With the block selected, edit its Block options - select a video and your desired layout
1. Publish/Update the post.

## Links

## Roadmap / todo list

1. Add documentation and demo videos for users
1. Add a widget
1. convert the plugin to the freemium model using Freemius
1. Add more features
1. bugfixes and many enhancements