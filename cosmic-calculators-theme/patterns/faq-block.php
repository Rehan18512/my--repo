<?php
/**
 * Title: Cosmic — FAQ Block
 * Slug: cosmic/faq-block
 * Categories: cosmic
 * Description: Native <details> accordion. Compatible with FAQ JSON-LD plugins.
 */
return array(
	'title'      => 'Cosmic — FAQ Block',
	'categories' => array( 'cosmic' ),
	'content'    => <<<HTML
<!-- wp:group {"tagName":"section","align":"wide","style":{"spacing":{"padding":{"top":"80px","bottom":"80px"}}}} -->
<section class="wp-block-group alignwide cosmic-faq" id="faq" style="padding-top:80px;padding-bottom:80px">
<!-- wp:heading {"level":2,"style":{"typography":{"fontSize":"clamp(40px,6vw,72px)"}}} --><h2>Questions, before you fall.</h2><!-- /wp:heading -->
<!-- wp:html -->
<div class="cosmic-faq-list" itemscope itemtype="https://schema.org/FAQPage">
	<details itemscope itemprop="mainEntity" itemtype="https://schema.org/Question" open>
		<summary itemprop="name">Are these calculators just for fun, or do they actually mean something?</summary>
		<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"><p itemprop="text">Both. Every cosmic calculator uses a deterministic algorithm &mdash; the same inputs always produce the same output. The love and crush tools use the classic letter-overlap method, then blend numerology and zodiac for context. Treat them as a beautifully designed conversation starter, not a fortune.</p></div>
	</details>
	<details itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
		<summary itemprop="name">Is my data private?</summary>
		<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"><p itemprop="text">100%. Everything runs in your browser. Your name, your crush&rsquo;s name and your birth date never leave the device. There&rsquo;s no account, no server, no analytics on inputs.</p></div>
	</details>
	<details itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
		<summary itemprop="name">What is the difference between Mulank and Bhagyank?</summary>
		<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"><p itemprop="text">Mulank is your root number &mdash; the single digit reduction of your day of birth. Bhagyank is your destiny number &mdash; the single digit reduction of your full date of birth. Both reveal different sides of your personality.</p></div>
	</details>
	<details itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
		<summary itemprop="name">Can I embed a calculator on my own site?</summary>
		<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"><p itemprop="text">Yes. Use the WordPress shortcodes <code>[love_calculator_cosmic]</code>, <code>[flames_calculator_cosmic]</code>, <code>[crush_calculator_cosmic]</code>, <code>[friendship_calculator_cosmic]</code> or <code>[mulank_calculator_cosmic]</code> on any page.</p></div>
	</details>
</div>
<!-- /wp:html -->
</section>
<!-- /wp:group -->
HTML
);
