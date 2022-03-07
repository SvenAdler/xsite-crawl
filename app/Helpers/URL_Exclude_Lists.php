<?php

namespace App\Helpers;

class URL_Exclude_Lists
{
    // Urls to exclude
    public array $excludeLists = array(
        'url_default' => array(
            "sort",
            "wap",
            "action=",
            "Smileys/",
            ".new.html",
            ".msg",
            "prev_next",
            "topic=",
            "board=",
            "runcrawl.php",
            "details-",
            "YOUR-LINK-HERE",
            "Themes",
            "avatars"
        ),

        'osCommerce' => array(
            "redirect.php",
            "js=",
            "js/",
            "sort=",
            "sort/",
            "action=",
            "action/",
            "write_review",
            "reviews_write",
            "printable",
            "manufacturers_id",
            "bestseller=",
            "price=",
            "currency=",
            "tell_a_friend",
            "login",
        ),

        'joomla' => array(
            "do_pdf=",
            "pop=1",
            "task=emailform",
            "task=trackback",
            "task=rss"
        ),

        'simple_Machines_Forum' => array(
            "dlattach",
            "sort",
            "action=",
            ".new.html",
            ".msg",
            "prev_next"
        ),

        'vBulletin' => array(
            "attachment.php",
            "calendar.php",
            "cron.php",
            "editpost.php",
            "image.php",
            "member.php",
            "memberlist.php",
            "misc.php",
            "newattachment.php",
            "newreply.php",
            "newthread.php",
            "online.php",
            "private.php",
            "profile.php",
            "register.php",
            "search.php",
            "usercp.php",
            "goto=",
            "p=",
            "sort=",
            "order=",
            "mode=",
        ),

        'phpBB' => array(
            "p=",
            "mode=",
            "mark=",
            "order=",
            "highlight=",
            "profile.php",
            "privmsg.php",
            "posting.php",
            "view=previous",
            "view=next",
            "search.php"
        ),

        'gallery2' => array(
            "core.UserLogin",
            "core.UserRecoverPassword",
            "g2_return",
            "search.",
            "slideshow"
        ),

        'cubeCart' => array(
            "ccUser=",
            "skins",
            "thumbs",
            "sort_",
            "redir",
            "review=",
            "tell",
            "act=taf",
            "language="
        ));
}