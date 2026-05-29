<?php
/**
 * Friendship Calculator  ->  shortcode [friendship_calculator]
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'cts_friendship_render' ) ) {

    function cts_friendship_render( $atts = array() ) {
        $uid = 'fc-' . wp_rand( 1000, 9999 );
        ob_start();
        echo cts_shared_assets(); // phpcs:ignore WordPress.Security.EscapeOutput
        ?>
<div class="cts-wrap cts-friendship" id="<?php echo esc_attr( $uid ); ?>" data-tool="friendship">

    <div class="cts-toolbar">
        <div class="cts-toggle" role="group" aria-label="Language">
            <button type="button" class="cts-seg cts-on" data-lang="en">EN</button>
            <button type="button" class="cts-seg" data-lang="hi">हिंदी</button>
        </div>
        <button type="button" class="cts-adv-btn" data-role="adv-toggle">
            <span>&#9881;</span><span data-en="Advanced" data-hi="एडवांस्ड">Advanced</span>
        </button>
    </div>

    <header class="cts-header">
        <div class="cts-h-icon">&#129309;</div>
        <h1 data-en="Friendship Calculator" data-hi="फ्रेंडशिप कैलकुलेटर">Friendship Calculator</h1>
        <p class="cts-h-sub" data-en="Discover how strong your friendship truly is" data-hi="जानिए आपकी दोस्ती कितनी मज़बूत है">Discover how strong your friendship truly is</p>
        <div class="cts-stats">
            <div class="cts-stat"><div class="cts-stat-num" data-role="counter">2,71,540</div><div class="cts-stat-lbl" data-en="Tests Today" data-hi="आज टेस्ट">Tests Today</div></div>
            <div class="cts-stat"><div class="cts-stat-num">4.9&#9733;</div><div class="cts-stat-lbl" data-en="Rating" data-hi="रेटिंग">Rating</div></div>
            <div class="cts-stat"><div class="cts-stat-num">100%</div><div class="cts-stat-lbl" data-en="Free" data-hi="फ्री">Free</div></div>
        </div>
    </header>

    <section class="cts-card">
        <!-- Input -->
        <div data-role="input">
            <div class="cts-inputs">
                <div class="cts-field">
                    <div class="cts-avatar cts-a" data-role="av-a">?</div>
                    <input type="text" class="cts-input" data-role="name-a" maxlength="30" autocomplete="off" placeholder="Your name" data-ph-en="Your name" data-ph-hi="आपका नाम" />
                </div>
                <div class="cts-vs" aria-hidden="true">&#129309;</div>
                <div class="cts-field">
                    <div class="cts-avatar cts-b" data-role="av-b">?</div>
                    <input type="text" class="cts-input" data-role="name-b" maxlength="30" autocomplete="off" placeholder="Friend's name" data-ph-en="Friend's name" data-ph-hi="दोस्त का नाम" />
                </div>
            </div>
            <div class="cts-error" data-role="error" data-en="Please enter both names to continue." data-hi="कृपया दोनों नाम दर्ज करें।">Please enter both names to continue.</div>
            <button type="button" class="cts-btn cts-btn-primary" data-role="calc" data-en="Check Friendship &#129309;" data-hi="दोस्ती जांचें &#129309;">Check Friendship &#129309;</button>
            <div class="cts-trust">
                <span data-en="&#128274; Private" data-hi="&#128274; प्राइवेट">&#128274; Private</span>
                <span data-en="&#9889; Instant" data-hi="&#9889; इंस्टेंट">&#9889; Instant</span>
                <span data-en="&#127942; Accurate" data-hi="&#127942; सटीक">&#127942; Accurate</span>
            </div>
        </div>

        <!-- Loading -->
        <div class="cts-loading" data-role="loading">
            <div class="cts-rings"><div class="cts-ring"></div><div class="cts-ring"></div><div class="cts-ring"></div><div class="cts-ring-emoji">&#129309;</div></div>
            <div class="cts-load-title" data-role="load-title">&#129309;</div>
            <div class="cts-load-step" data-role="load-step"></div>
            <div class="cts-progress"><div class="cts-progress-bar" data-role="bar"></div></div>
        </div>

        <!-- Result -->
        <div class="cts-result" data-role="result">
            <div class="cts-rcard">
                <div class="cts-rc-top">
                    <div class="cts-rc-name"><div class="cts-avatar cts-a" data-role="rc-av-a">?</div><span data-role="rc-n-a"></span></div>
                    <div class="cts-rc-mid">&#129309;</div>
                    <div class="cts-rc-name"><div class="cts-avatar cts-b" data-role="rc-av-b">?</div><span data-role="rc-n-b"></span></div>
                </div>
                <div class="cts-ring-wrap">
                    <svg viewBox="0 0 200 200" aria-hidden="true">
                        <defs><linearGradient id="<?php echo esc_attr( $uid ); ?>-g" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#f4c430"/><stop offset="100%" stop-color="#b558d6"/></linearGradient></defs>
                        <circle class="cts-ring-bg" cx="100" cy="100" r="86"/>
                        <circle class="cts-ring-fg" data-role="ring" cx="100" cy="100" r="86" stroke="url(#<?php echo esc_attr( $uid ); ?>-g)" stroke-dasharray="540.35" stroke-dashoffset="540.35"/>
                    </svg>
                    <div class="cts-percent"><div><span class="cts-percent-num" data-role="pct">0</span><span class="cts-percent-sym">%</span></div><div class="cts-percent-sub" data-en="Friendship" data-hi="दोस्ती">Friendship</div></div>
                </div>
                <div class="cts-level" data-role="level"></div>
                <p class="cts-rc-desc" data-role="desc"></p>
                <div class="cts-watermark" data-role="wm"></div>
            </div>

            <!-- Metric bars -->
            <div class="cts-bars">
                <div class="cts-bar-row"><div class="cts-bar-top"><span data-en="&#128591; Loyalty" data-hi="&#128591; वफ़ादारी">&#128591; Loyalty</span><span data-role="b1-v">0%</span></div><div class="cts-bar"><div class="cts-bar-fill" data-role="b1"></div></div></div>
                <div class="cts-bar-row"><div class="cts-bar-top"><span data-en="&#128172; Understanding" data-hi="&#128172; समझ">&#128172; Understanding</span><span data-role="b2-v">0%</span></div><div class="cts-bar"><div class="cts-bar-fill" data-role="b2"></div></div></div>
                <div class="cts-bar-row"><div class="cts-bar-top"><span data-en="&#128526; Fun Vibes" data-hi="&#128526; मस्ती">&#128526; Fun Vibes</span><span data-role="b3-v">0%</span></div><div class="cts-bar"><div class="cts-bar-fill" data-role="b3"></div></div></div>
                <div class="cts-bar-row"><div class="cts-bar-top"><span data-en="&#9854; Long-term Bond" data-hi="&#9854; लंबा साथ">&#9854; Long-term Bond</span><span data-role="b4-v">0%</span></div><div class="cts-bar"><div class="cts-bar-fill" data-role="b4"></div></div></div>
            </div>

            <!-- Extras: emoji / career / pet / song -->
            <div class="cts-extras" data-role="extras"></div>

            <!-- Golden hints -->
            <div class="cts-hints">
                <h3 data-role="hints-title">&#11088; <span data-en="Golden Hints" data-hi="गोल्डन हिंट्स">Golden Hints</span></h3>
                <div class="cts-hints-grid" data-role="hints"></div>
            </div>

            <!-- Advice -->
            <div class="cts-advice">
                <h3>&#129302; <span data-en="Friendship Advice" data-hi="दोस्ती की सलाह">Friendship Advice</span></h3>
                <p data-role="advice"></p>
                <div class="cts-tags" data-role="tags"></div>
            </div>

            <!-- Advanced -->
            <div class="cts-adv-panel" data-role="adv-panel">
                <h3>&#128302; <span data-en="Advanced Friendship Report" data-hi="एडवांस्ड फ्रेंडशिप रिपोर्ट">Advanced Friendship Report</span></h3>
                <div class="cts-adv-grid" data-role="adv-grid"></div>
            </div>

            <!-- Share + download -->
            <div class="cts-share">
                <a href="#" class="cts-share-btn cts-sb-wa" data-role="wa" target="_blank" rel="noopener">&#128241; WhatsApp</a>
                <a href="#" class="cts-share-btn cts-sb-tw" data-role="tw" target="_blank" rel="noopener">&#119991; Twitter</a>
                <button type="button" class="cts-share-btn cts-sb-dl" data-role="dl">&#11015; <span data-en="Download" data-hi="डाउनलोड">Download</span></button>
                <button type="button" class="cts-share-btn cts-sb-copy" data-role="copy">&#128279; <span data-en="Copy Link" data-hi="लिंक कॉपी">Copy Link</span></button>
            </div>

            <button type="button" class="cts-btn cts-try" data-role="try">&#128260; <span data-en="Try Again" data-hi="दोबारा करें">Try Again</span></button>
        </div>
    </section>

    <!-- Levels -->
    <section class="cts-levels">
        <div class="cts-lvl"><div class="cts-lvl-icon">&#128081;</div><h4 data-en="Soul Friends" data-hi="सोल फ्रेंड्स">Soul Friends</h4><div class="cts-lvl-range">90-100%</div><p class="cts-lvl-desc" data-en="Friends for life" data-hi="ज़िंदगी भर के दोस्त">Friends for life</p></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#129505;</div><h4 data-en="Best Buddies" data-hi="बेस्ट बडीज़">Best Buddies</h4><div class="cts-lvl-range">70-89%</div><p class="cts-lvl-desc" data-en="Unbreakable bond" data-hi="अटूट रिश्ता">Unbreakable bond</p></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#129309;</div><h4 data-en="Good Friends" data-hi="अच्छे दोस्त">Good Friends</h4><div class="cts-lvl-range">50-69%</div><p class="cts-lvl-desc" data-en="Solid friendship" data-hi="मज़बूत दोस्ती">Solid friendship</p></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#127793;</div><h4 data-en="Growing Bond" data-hi="बढ़ता रिश्ता">Growing Bond</h4><div class="cts-lvl-range">30-49%</div><p class="cts-lvl-desc" data-en="Give it time" data-hi="वक्त दें">Give it time</p></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#128075;</div><h4 data-en="New Spark" data-hi="नई शुरुआत">New Spark</h4><div class="cts-lvl-range">0-29%</div><p class="cts-lvl-desc" data-en="Just getting started" data-hi="अभी शुरुआत">Just getting started</p></div>
    </section>

    <!-- Related -->
    <section class="cts-related">
        <h2 data-en="Try More Fun Calculators" data-hi="और मज़ेदार कैलकुलेटर">Try More Fun Calculators</h2>
        <div class="cts-related-grid">
            <a class="cts-rt" href="/crush-calculator/"><div class="cts-rt-icon">&#128150;</div><h4 data-en="Crush Calculator" data-hi="क्रश कैलकुलेटर">Crush Calculator</h4><p data-en="Does your crush like you back?" data-hi="क्या आपका क्रश आपको पसंद करता है?">Does your crush like you back?</p></a>
            <a class="cts-rt" href="/mulank-calculator/"><div class="cts-rt-icon">&#128302;</div><h4 data-en="Mulank Calculator" data-hi="मूलांक कैलकुलेटर">Mulank Calculator</h4><p data-en="Numerology by date of birth" data-hi="जन्मतिथि से अंक ज्योतिष">Numerology by date of birth</p></a>
            <a class="cts-rt" href="/love-calculator/"><div class="cts-rt-icon">&#10084;</div><h4 data-en="Love Calculator" data-hi="लव कैलकुलेटर">Love Calculator</h4><p data-en="Test your love compatibility" data-hi="अपनी लव कम्पैटिबिलिटी जांचें">Test your love compatibility</p></a>
        </div>
    </section>

    <p class="cts-foot" data-en="100% private &middot; works in your browser &middot; no data is stored" data-hi="100% प्राइवेट &middot; आपके ब्राउज़र में चलता है &middot; कोई डेटा सेव नहीं होता">100% private &middot; works in your browser &middot; no data is stored</p>

    <script type="application/ld+json">
    {"@context":"https://schema.org","@type":"SoftwareApplication","name":"Friendship Calculator","applicationCategory":"LifestyleApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"},"aggregateRating":{"@type":"AggregateRating","ratingValue":"4.9","ratingCount":"9421"}}
    </script>
</div>

<script>
(function(){
    'use strict';
    var C = window.CTS;
    var root = document.getElementById('<?php echo esc_js( $uid ); ?>');
    if (!root || !C) { return; }
    var $ = function(r){ return root.querySelector('[data-role="'+r+'"]'); };
    var lang = 'en';

    var T = {
        en: {
            steps: ['🔍 Reading your names...','🤝 Measuring the bond...','✨ Checking the vibes...','🎉 Almost there...'],
            calculating: 'Calculating...',
            levels: [
                {min:90, e:'👑', n:'Soul Friends'},
                {min:70, e:'💞', n:'Best Buddies'},
                {min:50, e:'🤝', n:'Good Friends'},
                {min:30, e:'🌱', n:'Growing Bond'},
                {min:0,  e:'👋', n:'New Spark'}
            ],
            desc: {
                90: '{a} & {b}, this is a once-in-a-lifetime friendship. You finish each other’s sentences and show up without being asked. Guard this bond — it is pure gold.',
                70: '{a} & {b}, you two are the real deal. Trust runs deep and laughter comes easy. Keep making memories — this friendship is built to last.',
                50: '{a} & {b}, there is a warm, genuine bond here. A little more time together and a few honest talks will take it to the next level.',
                30: '{a} & {b}, your friendship is still finding its rhythm. Reach out more often — the best bonds grow from small, consistent moments.',
                0:  '{a} & {b}, every great friendship starts somewhere. Say hi, share a laugh, and let the connection breathe. The spark is just beginning.'
            },
            hints: {
                hi: [
                    {i:'🎁',t:'Surprise Often',d:'A small surprise gift keeps the friendship alive and warm.'},
                    {i:'📞',t:'Stay in Touch',d:'A quick call beats a hundred texts. Hear each other’s voice.'},
                    {i:'🤐',t:'Keep Secrets',d:'Be the friend who never breaks a confidence. Trust is everything.'},
                    {i:'🎉',t:'Show Up',d:'Be there on the big days — and the ordinary ones too.'}
                ],
                mid: [
                    {i:'☕',t:'Plan a Meetup',d:'Fix a coffee or game night this week. Real time builds real bonds.'},
                    {i:'👂',t:'Listen More',d:'Ask one good question and truly listen to the answer.'},
                    {i:'🙏',t:'Forgive Fast',d:'Don’t let small things grow big. Clear the air early.'},
                    {i:'🌟',t:'Celebrate Them',d:'Cheer their wins loudly. Friends lift each other up.'}
                ],
                low: [
                    {i:'👋',t:'Break the Ice',d:'Send the first message. Most great friendships start with a hello.'},
                    {i:'🎯',t:'Find Common Ground',d:'Discover one shared hobby and build from there.'},
                    {i:'😊',t:'Be Yourself',d:'Real friends are drawn to the real you. No masks needed.'},
                    {i:'⏳',t:'Give it Time',d:'Trust grows slowly. Stay patient and keep showing up.'}
                ]
            },
            advice: {
                hi: {text:'{a} & {b}, you have something rare — a friendship that feels like family. Protect it with honesty, presence, and the occasional silly adventure. The best friendships are not perfect; they are loyal.', tags:['Loyal Bond','Lifetime Friends','Deep Trust','Pure Vibes']},
                mid:{text:'{a} & {b}, your friendship has a strong, steady heart. Water it with quality time and honest conversations and watch it bloom into something unbreakable.', tags:['Growing Strong','Good Energy','Worth It','True Bond']},
                low:{text:'{a} & {b}, every legendary friendship started as two strangers. Take the first step, stay genuine, and let the bond build naturally. Magic takes a little time.', tags:['Fresh Start','New Connection','Be Patient','Stay Real']}
            },
            extras: {
                emojiTitle:'Friendship Emoji', careerTitle:'Dream Team Career', petTitle:'Perfect Pet', songTitle:'Your Anthem',
                emojis:['🤝 💛 ✨','🫶 🌟 💫','😎 🎉 🔥','🧩 🌈 💞','☕ 📚 😌'],
                careers:['Co-founders of a startup','A travel-vlogging duo','Partners in a cafe','A comedy podcast team','Event planners extraordinaire'],
                pets:['A loyal Golden Retriever 🐕','A playful pair of cats 🐈','A cheeky parrot 🦜','A bunny duo 🐰','A husky for adventures 🐺'],
                songs:['"Count on Me" – Bruno Mars','"Yaaron" – KK','"You’ve Got a Friend" – Carole King','"Dil Dhadakne Do" – ZNMD','"Lean on Me" – Bill Withers']
            },
            advLabels:{compat:'Compatibility Number',element:'Shared Element',meetup:'Best Hangout',gift:'Ideal Gift',duration:'Bond Forecast',keyword:'Friendship Keyword'},
            wm:'friendship-calculator', share:'🤝 Friendship Result!'
        },
        hi: {
            steps: ['🔍 आपके नाम पढ़ रहे हैं...','🤝 रिश्ता माप रहे हैं...','✨ वाइब्स चेक कर रहे हैं...','🎉 बस हो गया...'],
            calculating: 'गणना हो रही है...',
            levels: [
                {min:90, e:'👑', n:'सोल फ्रेंड्स'},
                {min:70, e:'💞', n:'बेस्ट बडीज़'},
                {min:50, e:'🤝', n:'अच्छे दोस्त'},
                {min:30, e:'🌱', n:'बढ़ता रिश्ता'},
                {min:0,  e:'👋', n:'नई शुरुआत'}
            ],
            desc: {
                90: '{a} और {b}, यह ज़िंदगी में एक बार मिलने वाली दोस्ती है। बिना कहे एक-दूसरे का साथ देते हैं। इस रिश्ते को संभालकर रखें — यह सोना है।',
                70: '{a} और {b}, आप दोनों सच्चे दोस्त हैं। भरोसा गहरा है और हंसी आसान। यादें बनाते रहिए — यह दोस्ती लंबी चलेगी।',
                50: '{a} और {b}, यहां एक सच्चा और गर्मजोशी भरा रिश्ता है। थोड़ा और वक्त और कुछ खुली बातें इसे और ऊपर ले जाएंगी।',
                30: '{a} और {b}, आपकी दोस्ती अभी लय पकड़ रही है। अक्सर बात करें — छोटे पलों से ही बड़े रिश्ते बनते हैं।',
                0:  '{a} और {b}, हर शानदार दोस्ती कहीं से शुरू होती है। हाय कहिए, हंसी बांटिए और रिश्ते को सांस लेने दीजिए।'
            },
            hints: {
                hi: [
                    {i:'🎁',t:'सरप्राइज़ दें',d:'छोटा सा तोहफ़ा दोस्ती को हमेशा गर्म रखता है।'},
                    {i:'📞',t:'संपर्क में रहें',d:'सौ मैसेज से अच्छा एक कॉल। आवाज़ सुनिए।'},
                    {i:'🤐',t:'राज़ रखें',d:'ऐसे दोस्त बनें जो भरोसा कभी न तोड़े।'},
                    {i:'🎉',t:'साथ निभाएं',d:'बड़े दिनों पर — और आम दिनों पर भी — साथ रहें।'}
                ],
                mid: [
                    {i:'☕',t:'मुलाक़ात तय करें',d:'इस हफ्ते कॉफी या गेम नाइट रखें।'},
                    {i:'👂',t:'सुनिए ज़्यादा',d:'एक अच्छा सवाल पूछें और सच में सुनिए।'},
                    {i:'🙏',t:'जल्दी माफ़ करें',d:'छोटी बातों को बड़ा न बनने दें।'},
                    {i:'🌟',t:'उन्हें सराहें',d:'उनकी जीत पर खुलकर खुश हों।'}
                ],
                low: [
                    {i:'👋',t:'बातचीत शुरू करें',d:'पहला मैसेज आप भेजें। दोस्ती हाय से शुरू होती है।'},
                    {i:'🎯',t:'समान रुचि खोजें',d:'एक कॉमन शौक ढूंढें और वहीं से बढ़ें।'},
                    {i:'😊',t:'खुद बने रहें',d:'सच्चे दोस्त असली आपको पसंद करते हैं।'},
                    {i:'⏳',t:'वक्त दें',d:'भरोसा धीरे बनता है। धैर्य रखें।'}
                ]
            },
            advice: {
                hi: {text:'{a} और {b}, आपके पास कुछ दुर्लभ है — ऐसी दोस्ती जो परिवार जैसी लगे। ईमानदारी और साथ से इसे संभालें। सबसे अच्छी दोस्ती परफेक्ट नहीं, वफ़ादार होती है।', tags:['वफ़ादार रिश्ता','उम्र भर के दोस्त','गहरा भरोसा','शुद्ध वाइब']},
                mid:{text:'{a} और {b}, आपकी दोस्ती का दिल मज़बूत है। क्वालिटी टाइम और खुली बातों से इसे और अटूट बनाइए।', tags:['मज़बूत होता रिश्ता','अच्छी एनर्जी','क़ीमती','सच्चा बंधन']},
                low:{text:'{a} और {b}, हर मशहूर दोस्ती दो अजनबियों से शुरू हुई थी। पहला कदम उठाइए और रिश्ते को बनने दीजिए।', tags:['नई शुरुआत','नया रिश्ता','धैर्य रखें','असली रहें']}
            },
            extras: {
                emojiTitle:'दोस्ती इमोजी', careerTitle:'ड्रीम टीम करियर', petTitle:'परफेक्ट पेट', songTitle:'आपका गाना',
                emojis:['🤝 💛 ✨','🫶 🌟 💫','😎 🎉 🔥','🧩 🌈 💞','☕ 📚 😌'],
                careers:['स्टार्टअप के को-फाउंडर','ट्रैवल-व्लॉगिंग जोड़ी','कैफे के पार्टनर','कॉमेडी पॉडकास्ट टीम','बेहतरीन इवेंट प्लानर'],
                pets:['वफ़ादार गोल्डन रिट्रीवर 🐕','दो शरारती बिल्लियां 🐈','एक चंचल तोता 🦜','खरगोश की जोड़ी 🐰','एडवेंचर के लिए हस्की 🐺'],
                songs:['"यारों" – KK','"दिल धड़कने दो" – ZNMD','"तेरे जैसा यार कहां" – रफ़ी','"मेरे यार" – Various','"Count on Me" – Bruno Mars']
            },
            advLabels:{compat:'कम्पैटिबिलिटी नंबर',element:'साझा तत्व',meetup:'बेस्ट हैंगआउट',gift:'आदर्श तोहफ़ा',duration:'रिश्ते का भविष्य',keyword:'दोस्ती कीवर्ड'},
            wm:'friendship-calculator', share:'🤝 फ्रेंडशिप रिज़ल्ट!'
        }
    };

    var ELEMENTS = {en:['Fire 🔥','Water 💧','Earth 🌍','Air 🌬'], hi:['अग्नि 🔥','जल 💧','पृथ्वी 🌍','वायु 🌬']};
    var MEET = {en:['Coffee shop ☕','Road trip 🚗','Movie night 🎬','Gaming session 🎮'], hi:['कॉफी शॉप ☕','रोड ट्रिप 🚗','मूवी नाइट 🎬','गेमिंग 🎮']};
    var GIFTS = {en:['Handwritten letter ✍️','Concert tickets 🎟','Custom playlist 🎵','Matching bracelets 📿'], hi:['हाथ से लिखा पत्र ✍️','कॉन्सर्ट टिकट 🎟','कस्टम प्लेलिस्ट 🎵','मैचिंग ब्रेसलेट 📿']};
    var DURATION = {en:['A lifetime 💫','Many golden years ✨','Growing every year 🌱','A bright road ahead 🛣'], hi:['उम्र भर 💫','कई सुनहरे साल ✨','हर साल बढ़ता 🌱','उज्ज्वल राह 🛣']};
    var KEYWORD = {en:['Loyalty','Laughter','Trust','Adventure'], hi:['वफ़ादारी','हंसी','भरोसा','एडवेंचर']};

    /* --- algorithm --- */
    function clean(s){ return (s||'').toLowerCase().replace(/[^a-zऀ-ॿ]/g,''); }
    function score(n1,n2){
        var a = clean(n1), b = clean(n2);
        if (!a || !b) { return 50; }
        var fa={}, fb={}, i;
        for (i=0;i<a.length;i++){ fa[a[i]]=(fa[a[i]]||0)+1; }
        for (i=0;i<b.length;i++){ fb[b[i]]=(fb[b[i]]||0)+1; }
        var keys={}, k, ov=0, tot=0;
        for (k in fa){ keys[k]=1; } for (k in fb){ keys[k]=1; }
        for (k in keys){ ov+=Math.min(fa[k]||0,fb[k]||0); tot+=Math.max(fa[k]||0,fb[k]||0); }
        var overlap = tot? (ov/tot)*100 : 50;
        var sa=0, sb=0;
        for (i=0;i<a.length;i++){ sa+=a.charCodeAt(i); }
        for (i=0;i<b.length;i++){ sb+=b.charCodeAt(i); }
        var num = C.reduceDigit(sa+sb)*10;
        var diff = Math.abs(a.length-b.length);
        var len = Math.max(0,100-diff*10);
        var sd = C.seed(a+'|'+b);
        var rand = Math.abs(Math.sin(sd))*30;
        var raw = overlap*0.38 + num*0.24 + len*0.18 + rand*0.6;
        var sc = Math.round(raw);
        if (sc<15){ sc = 15 + (Math.abs(sd)%20); }
        if (sc>99){ sc = 99; }
        return sc;
    }
    function metrics(n1,n2,sc){
        var sd = C.seed(clean(n1)+'~'+clean(n2));
        function v(off){ var r=Math.abs(Math.sin(sd+off))*22-11; return Math.max(20,Math.min(99,Math.round(sc+r))); }
        return {b1:v(1),b2:v(2),b3:v(3),b4:v(4)};
    }
    function levelFor(sc){ var L=T[lang].levels; for (var i=0;i<L.length;i++){ if (sc>=L[i].min){ return L[i]; } } return L[L.length-1]; }
    function tier(sc){ return sc>=70?'hi':(sc>=40?'mid':'low'); }
    function band(sc){ return sc>=90?90:sc>=70?70:sc>=50?50:sc>=30?30:0; }

    var state = {};

    function render(){
        var t = T[lang], n1 = state.n1, n2 = state.n2, sc = state.sc, m = state.m;
        var lvl = levelFor(sc), tr = tier(sc), sd = C.seed(clean(n1)+clean(n2));
        $('rc-n-a').textContent = n1; $('rc-n-b').textContent = n2;
        $('rc-av-a').textContent = n1.charAt(0).toUpperCase();
        $('rc-av-b').textContent = n2.charAt(0).toUpperCase();
        $('level').textContent = lvl.e + ' ' + lvl.n;
        $('desc').textContent = t.desc[band(sc)].replace('{a}',n1).replace('{b}',n2);
        $('wm').textContent = t.wm + ' ❤';

        C.animateNum($('pct'),0,sc,1700);
        var circ = 2*Math.PI*86;
        setTimeout(function(){ $('ring').style.strokeDashoffset = circ-(circ*sc/100); },80);
        setTimeout(function(){
            $('b1').style.width=m.b1+'%'; $('b2').style.width=m.b2+'%'; $('b3').style.width=m.b3+'%'; $('b4').style.width=m.b4+'%';
            $('b1-v').textContent=m.b1+'%'; $('b2-v').textContent=m.b2+'%'; $('b3-v').textContent=m.b3+'%'; $('b4-v').textContent=m.b4+'%';
        },200);

        // extras
        var ex = t.extras;
        var cards = [
            {e:'😍', ti:ex.emojiTitle, v:C.pick(ex.emojis,sd,1), note:''},
            {e:'💼', ti:ex.careerTitle, v:C.pick(ex.careers,sd,2), note:''},
            {e:'🐾', ti:ex.petTitle, v:C.pick(ex.pets,sd,3), note:''},
            {e:'🎵', ti:ex.songTitle, v:C.pick(ex.songs,sd,4), note:''}
        ];
        var eg = $('extras'); eg.innerHTML='';
        cards.forEach(function(c,i){
            var d=document.createElement('div'); d.className='cts-x'; d.style.animationDelay=(i*0.08)+'s';
            d.innerHTML='<div class="cts-x-head"><span class="cts-x-emoji">'+c.e+'</span><span class="cts-x-title">'+C.escapeHtml(c.ti)+'</span></div><p class="cts-x-val">'+C.escapeHtml(c.v)+'</p>';
            eg.appendChild(d);
        });

        // hints
        var hints = t.hints[tr], hg = $('hints'); hg.innerHTML='';
        hints.forEach(function(h,i){
            var d=document.createElement('div'); d.className='cts-hint'; d.style.animationDelay=(i*0.1)+'s';
            d.innerHTML='<div class="cts-hint-icon">'+h.i+'</div><h4>'+C.escapeHtml(h.t)+'</h4><p>'+C.escapeHtml(h.d)+'</p>';
            hg.appendChild(d);
        });

        // advice
        var adv = t.advice[tr];
        $('advice').textContent = adv.text.replace('{a}',n1).replace('{b}',n2);
        var tags=$('tags'); tags.innerHTML='';
        adv.tags.forEach(function(tg){ var s=document.createElement('span'); s.className='cts-tag'; s.textContent=tg; tags.appendChild(s); });

        // advanced
        var al = t.advLabels;
        var advData = [
            [al.compat, C.reduceDigit(C.seed(clean(n1))+C.seed(clean(n2)))],
            [al.element, C.pick(ELEMENTS[lang],sd,5)],
            [al.meetup, C.pick(MEET[lang],sd,6)],
            [al.gift, C.pick(GIFTS[lang],sd,7)],
            [al.duration, C.pick(DURATION[lang],sd,8)],
            [al.keyword, C.pick(KEYWORD[lang],sd,9)]
        ];
        var ag=$('adv-grid'); ag.innerHTML='';
        advData.forEach(function(p){ var d=document.createElement('div'); d.className='cts-adv-item'; d.innerHTML='<div class="k">'+C.escapeHtml(p[0])+'</div><div class="v">'+C.escapeHtml(String(p[1]))+'</div>'; ag.appendChild(d); });
        if (root.classList.contains('cts-adv-active')) { $('adv-panel').classList.add('cts-show'); }

        // share
        var url = window.location.href;
        var msg = t.share+'\n\n'+n1+' 🤝 '+n2+' = '+sc+'%\n'+lvl.e+' '+lvl.n+'\n\n'+url;
        $('wa').href = C.shareWhatsApp(msg);
        $('tw').href = C.shareTwitter(n1+' 🤝 '+n2+' = '+sc+'% '+lvl.n, url);

        if (sc>=70){ setTimeout(C.confetti,600); }
        setTimeout(function(){ $('result').scrollIntoView({behavior:'smooth',block:'start'}); },100);
    }

    function go(){
        var n1=($('name-a').value||'').trim(), n2=($('name-b').value||'').trim();
        var err=$('error');
        if (!n1||!n2){ err.classList.add('cts-show'); return; }
        if (n1.length<2||n2.length<2){ err.textContent = lang==='hi'?'नाम कम से कम 2 अक्षर का हो।':'Names should be at least 2 characters.'; err.classList.add('cts-show'); return; }
        err.classList.remove('cts-show');
        state.n1=n1; state.n2=n2; state.sc=score(n1,n2); state.m=metrics(n1,n2,state.sc);
        $('input').style.display='none';
        var ld=$('loading'); ld.style.display='block'; ld.classList.add('cts-show');
        $('load-title').textContent = n1+' 🤝 '+n2;
        $('bar').style.width='0%';
        C.runLoading($('load-step'),$('bar'),T[lang].steps,function(){
            ld.classList.remove('cts-show'); ld.style.display='none';
            $('result').classList.add('cts-show'); render();
        });
    }

    function reset(){
        $('result').classList.remove('cts-show');
        $('loading').classList.remove('cts-show'); $('loading').style.display='none';
        $('input').style.display='block';
        $('name-a').value=''; $('name-b').value=''; $('av-a').textContent='?'; $('av-b').textContent='?';
        $('pct').textContent='0'; $('ring').style.strokeDashoffset=540.35;
        ['b1','b2','b3','b4'].forEach(function(id){ $(id).style.width='0%'; });
        $('adv-panel').classList.toggle('cts-show', root.classList.contains('cts-adv-active'));
        $('input').scrollIntoView({behavior:'smooth',block:'start'});
        setTimeout(function(){ $('name-a').focus(); },400);
    }

    // avatars
    function av(input,avatar){ var v=(input.value||'').trim(); avatar.textContent=v?v.charAt(0).toUpperCase():'?'; $('error').classList.remove('cts-show'); }
    $('name-a').addEventListener('input',function(){ av($('name-a'),$('av-a')); });
    $('name-b').addEventListener('input',function(){ av($('name-b'),$('av-b')); });
    [$('name-a'),$('name-b')].forEach(function(el){ el.addEventListener('keydown',function(e){ if (e.key==='Enter'){ e.preventDefault(); go(); } }); });

    $('calc').addEventListener('click',go);
    $('try').addEventListener('click',reset);
    $('copy').addEventListener('click',function(){ C.copyLink(this, lang==='hi'?'✅ कॉपी हुआ!':'✅ Copied!'); });
    $('dl').addEventListener('click',function(){
        var lvl=levelFor(state.sc);
        var ok=C.downloadCard({
            brand:'Friendship Calculator', title:state.n1+' & '+state.n2,
            percent:state.sc, centerText:state.sc+'%', centerSub:lang==='hi'?'दोस्ती':'Friendship',
            level:lvl.e+' '+lvl.n, desc:T[lang].desc[band(state.sc)].replace('{a}',state.n1).replace('{b}',state.n2),
            footer:'friendship-calculator', file:'friendship-'+state.sc
        });
        if (!ok){ alert(lang==='hi'?'स्क्रीनशॉट लेकर सेव करें!':'Take a screenshot to save your result!'); }
    });

    // language
    C.qa(root,'.cts-seg').forEach(function(b){
        b.addEventListener('click',function(){
            lang=b.getAttribute('data-lang');
            C.qa(root,'.cts-seg').forEach(function(x){ x.classList.toggle('cts-on', x===b); });
            C.applyLang(root,lang);
            if ($('result').classList.contains('cts-show')){ render(); }
        });
    });

    // advanced toggle
    $('adv-toggle').addEventListener('click',function(){
        var on=root.classList.toggle('cts-adv-active');
        this.classList.toggle('cts-on',on);
        if ($('result').classList.contains('cts-show')){ $('adv-panel').classList.toggle('cts-show',on); }
    });

    C.applyLang(root,'en');
    C.liveCounter($('counter'),271540);
})();
</script>
        <?php
        return ob_get_clean();
    }

    add_shortcode( 'friendship_calculator', 'cts_friendship_render' );
}
