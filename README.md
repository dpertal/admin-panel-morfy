###Steps to install:

Copy admin folder in Root folder
    
    Website
        - admin ( Here )
        - content
        - libraries
        - plugins
        - plubic
        - themes
        - .htaccess
        - config.php
        - index.php

---
Browse to admin / database / configuration.json and write your settings

    {
        "Site_url": "http:\/\/localhost:8080\/morfy",
        "Timezone": "Europe\/Brussels",
        "Password": "demo", // default password
        "Key_1": "key_1", // encrypt key 1
        "Key_2": "key_2", // encrypt key 2
        "admin_email": "demo@gmail.com", // email
        "language": "english", // language
        "Debug": "true", // debug
        "Cms name": "Panel", // Name of logo
        "Folder cms name": "admin", // Name of folder
        // ace settings
        "Ace_theme": "monokai", 
        "Ace_emmet": "true",
        "Ace_tabsize": "2",
        "Ace_fontSize": "12",
        "Ace_autocompletion": "true"
    } 
    
    // Please if copy this file remove comments to work json file.
