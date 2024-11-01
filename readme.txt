=== Xxternal-RSS ===
Contributors: pretzlaff
Donate link: http://www.pretzlaff.info/wp/
Tags: rss, posts, pages, Google, Google-Reader, Google feeds
Requires at least: 2.1
Tested up to: 5.3.2
Stable tag: 0.1.12.1

Include external RSS-Feed into your posts and pages and now to sidebar.

== Description ==

(DE)
Mit Xxternal-RSS können RSS-Feeds ganz einfach in Posts oder Pages intregriert werden ohne das dort PHP-Code 
eingefügt werden muss. Im Adminbereich kann der RSS-Feed eingetragen werden und die Anzahl der Einträge aus 
dem Feed, die angezeigt werden sollen.

Im Artikel oder der Seite kann dann mit einem einfachen Eintrag der externe RSS-Feed eingesetzt werden:

[rss=1,url=]

= Update (DE) = 

CSS ID "xxternalrss" hinzugefügt, damit das Design angepasst werden kann. 

Nun können auch weitere Feeds in Seiten eingebunden werden. Für das Einsetzen in einen Beitrag oder einer Seite kann jetzt benutzt werden:

Den Standardfeed aus dem Adminbereich benutzen:

[rss=1,url=]

Zusätzlichen Feed eintragen. Nur den ersten Eintrag anzeigen:

[rss=1,url=http://www.example.de/feed/]

Bei einem Google-Reader Feed ist noch google=1 anzuhängen.

[rss=1,url=http://www.example.de/reader/feed/,google=1]

Zusätzlichen Feed eintragen. Die ersten 5 Einträge anzeigen:

[rss=5,url=http://www.example.de/feed/]

Google:
[rss=5,url=http://www.example.de/reader/feed/,google=1]

Zusätzlichen Feed eintragen. Die ersten 10 Einträge anzeigen:

[rss=10,url=http://www.example.de/feed/]

Google: 
[rss=10,url=http://www.example.de/reader/feed/,google=1]

Optional parameters:

extend=1
--------
Aktiviert in Version => 0.1.7 aber noch keine Funktion. In Version 0.1.8 posted dieser Paremeter den Title und den Text.

compact=1
---------
Aktiviert in Version => 0.1.7 aber noch keine Funktion. In Version 0.1.8 posted dieser Paremeter nur den Title.

google=1
--------
Aktiviert in Version => 0.1.7. Die Feed URL ist eine Google-Reader Feed URL, dann muss google=1 angegeben werden. Ohne diesen Parameter funktionieren Google Feeds nicht.

New in version 0.1.7. The Feed URL is a Google-Reader Feed URL add google=1. Without this paramter Google feeds does not works.

== Installation ==

(DE)


1. Laden Sie die Ordner `RSS-xxternal` auf Ihren Server in das Verzeichnis `/ wp-content/plugins /`.

2. Aktivieren Sie das Plugin über die "Plugins"-Menü in WordPress

(EN)

1. Upload the folder `xxternal-rss` to the `/wp-content/plugins/` directory

2. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. Adminpanel
2. xxternalrss in Page
3. xxternalrss in Post

== Frequently Asked Questions ==

= Can not insert Google-Reader Feeds =

Update Xxternal-RSS to Version => 0.1.7 this version works with Google-Reader Feeds.


