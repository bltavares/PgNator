=== Plugin Name ===
Contributors: bltavares
Donate link:
Tags: wpquery, pages, pagination
Requires at least: 2.0.2
Tested up to: 2.1
Stable tag: "trunk"

Dynamic paginator for WpQeuries

== Description ==

Dynamic paginator for WpQeuries. Generate your own loop with an easy paginator.

== Installation ==

1. Upload `pgnator` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create a PgNator

$pgnator = new Pgnator();
	ou
$pgnator = new Pgnator("path/to/your/own/style.css")

1. Generate your queries using Pgnator

$posts = $pgnator->content("normal=arguments&like=WPQuerie");
	ou
$posts = $pgnator->content("SELECT * FROM wp_posts",true);

1. Create your loop

while($posts) {
	$posts->the_post();
	/// Create your own code
	...
	///	
}


1. Generate page links

echo $pgnator->createMenu();

1. Done

== Frequently Asked Questions ==

= Where to get full description? =
[GitHub](https://github.com/bltavares/PgNator "Oficial repositorie")

== Screenshots ==


== Changelog ==

= 0.5 =
* Launch at github and WP Plugins

== Upgrade Notice ==

== Arbitrary section ==

