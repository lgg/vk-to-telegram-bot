# Config.php

## Content

* [Variations of posting](#variations-of-posting)
* [Basic info](#basic-info)
* [VK parameters](#vk)
* [Telegram parameters](#telegram)
* [Bot modes](#bot-modes)
* [Post cutting parameters](#post-cutting)
* [Parsing internal VK links](#parsing-internal-vk-links)
* [i18n](#i18n)
* [Logging](#logging)

## Variations of posting

* [one VK - one Telegram](./examples/vop/1vk-1t.md)
* [one VK - few Telegram channels](./examples/vop/1vk-ft.md)
* [few VK - one Telegram](./examples/vop/fvk-1t.md)
* [few VK - few Telegram channels](./examples/vop/fvk-ft.md)

## Basic info

* $configs - array of settings arrays
    * each array is group of settings for one pair/group of VK-to-Telegram sources and targets
* Files:
    * $file_log - file to save logs
    * $file_last - file to save last posts

## VK

| Parameter | Type   | Description |
| ------    | ------ | ------      |
| vk        | string | id of vk user or group to parse (**!IMPORTANT!** for users you should set `only numbers`, for groups `-numbers` (e.g. `1` is `id1`, `-1` is `club1`)) |
| vk_token  | string | VK service token([read more here](https://vk.com/dev/service_token)) |

## Telegram

| Parameter | Type   | Description |
| ------    | ------ | ------      |
| t_key     | string | bot api key |
| t_name    | string | bot name    |
| t_chat    | string | chat id/url **(without @)**, (e.g. `myawesomechannel`) |

## Bot modes

*//add block scheme//*
   
| Parameter         | Type    | Description |
| ------            | ------  | ------      |
| extended.active   | boolean | use Extended(`true`) or Simple(`false`) version of bot |
| extended.needLink | boolean | need to append link in extended mode                   |
| needPostPreview   | boolean | need to send text preview in simple mode               |

| extended.active | extended.needLink | needPostPreview | Result  |
| ------          | ------            | ------          | ------  |
| true            | false             | *ignored*       | full post text, all photos and other attachments will be sent to Telegram channel **without** original VK link |
| true            | true              | *ignored*       | full post text, all photos and other attachments will be sent to Telegram channel **with** original VK link    |
| false           | *ignored*         | true            | if text exists - text preview will be sent, plus link to original VK post |
| false           | *ignored*         | false           | only link to original VK post will be sent                                |
    
### Examples and explanations

* Extended
    * [needLink = false](./examples/modes/extended-needlink-false.md)
    * [needLink = true](./examples/modes/extended-needlink-true.md)
* Simple
    * [needPostPreview = false](./examples/modes/simple-preview-false.md)
    * [needPostPreview = true](./examples/modes/simple-preview-true.md)

## Post Cutting

| Parameter             | Type    | Description |
| ------                | ------  | ------      |
| textCutter.aggressive | boolean | defines TextPreview-cutting function behavior |
| textCutter.limit      | integer | uncutted letters limit                        |

| textCutter.aggressive | textCutter.limit | Result |
| ------                | ------           | ------ |
| false                 | ignored          | text will be cutted on first space(` `) or till text end |
| true                  | 3                | text will be cutted on `140+limit` symbol                |

### Examples and explanations

* [textCutter.aggressive=false](./examples/text-cutter/aggressive-false.md)
* [textCutter.aggressive=true](./examples/text-cutter/aggressive-true.md)

## Parsing internal VK links

| Parameter             | Type    | Description                                 |
| ------                | ------  | ------                                      |
| vkLinks.show          | boolean | defines delete or convert internal VK links |
| vkLinks.symbols.open  | string  | open symbol for full VK link                |
| vkLinks.symbols.close | string  | close symbol for full VK link               |

| vkLinks.show | vkLinks.symbols.open | vkLinks.symbols.close | Result |
| ------       | ------               | ------                | ------ |
| false        | ignored              | ignored               | internal VK link will be deleted from text                |
| true         | [                    | ]                     | internal VK link will be transformed to `text[full link]` |

### Examples and explanations

* [vkLinks.show=false](./examples/vk-links/show-false.md)
* [vkLinks.show=true](./examples/vk-links/show-true.md)

## i18n

*soon*

## Logging

*soon*
