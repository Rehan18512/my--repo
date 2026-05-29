<?php
/**
 * Crush Calculator  ->  shortcode [crush_calculator]
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'cts_crush_render' ) ) {

    function cts_crush_render( $atts = array() ) {
        $uid = 'cc-' . wp_rand( 1000, 9999 );
        ob_start();
        echo cts_shared_assets(); // phpcs:ignore WordPress.Security.EscapeOutput
        ?>
<div class="cts-wrap cts-crush" id="<?php echo esc_attr( $uid ); ?>" data-tool="crush">

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
        <div class="cts-h-icon">&#128150;</div>
        <h1 data-en="Crush Calculator" data-hi="क्रश कैलकुलेटर">Crush Calculator</h1>
        <p class="cts-h-sub" data-en="Find out if your crush secretly likes you back" data-hi="जानिए क्या आपका क्रश भी आपको पसंद करता है">Find out if your crush secretly likes you back</p>
        <div class="cts-stats">
            <div class="cts-stat"><div class="cts-stat-num" data-role="counter">3,12,760</div><div class="cts-stat-lbl" data-en="Tests Today" data-hi="आज टेस्ट">Tests Today</div></div>
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
                <div class="cts-vs" aria-hidden="true">&#128150;</div>
                <div class="cts-field">
                    <div class="cts-avatar cts-b" data-role="av-b">?</div>
                    <input type="text" class="cts-input" data-role="name-b" maxlength="30" autocomplete="off" placeholder="Crush's name" data-ph-en="Crush's name" data-ph-hi="क्रश का नाम" />
                </div>
            </div>
            <div class="cts-error" data-role="error" data-en="Please enter both names to continue." data-hi="कृपया दोनों नाम दर्ज करें।">Please enter both names to continue.</div>
            <button type="button" class="cts-btn cts-btn-primary" data-role="calc" data-en="Reveal My Crush Score &#128150;" data-hi="मेरा क्रश स्कोर देखें &#128150;">Reveal My Crush Score &#128150;</button>
            <div class="cts-trust">
                <span data-en="&#128274; Secret" data-hi="&#128274; गुप्त">&#128274; Secret</span>
                <span data-en="&#9889; Instant" data-hi="&#9889; इंस्टेंट">&#9889; Instant</span>
                <span data-en="&#128302; Astro-powered" data-hi="&#128302; ज्योतिष आधारित">&#128302; Astro-powered</span>
            </div>
        </div>

        <!-- Loading -->
        <div class="cts-loading" data-role="loading">
            <div class="cts-rings"><div class="cts-ring"></div><div class="cts-ring"></div><div class="cts-ring"></div><div class="cts-ring-emoji">&#128150;</div></div>
            <div class="cts-load-title" data-role="load-title">&#128150;</div>
            <div class="cts-load-step" data-role="load-step"></div>
            <div class="cts-progress"><div class="cts-progress-bar" data-role="bar"></div></div>
        </div>

        <!-- Result -->
        <div class="cts-result" data-role="result">
            <div class="cts-rcard">
                <div class="cts-rc-top">
                    <div class="cts-rc-name"><div class="cts-avatar cts-a" data-role="rc-av-a">?</div><span data-role="rc-n-a"></span></div>
                    <div class="cts-rc-mid">&#128150;</div>
                    <div class="cts-rc-name"><div class="cts-avatar cts-b" data-role="rc-av-b">?</div><span data-role="rc-n-b"></span></div>
                </div>
                <div class="cts-ring-wrap">
                    <svg viewBox="0 0 200 200" aria-hidden="true">
                        <defs><linearGradient id="<?php echo esc_attr( $uid ); ?>-g" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#f4c430"/><stop offset="100%" stop-color="#b558d6"/></linearGradient></defs>
                        <circle class="cts-ring-bg" cx="100" cy="100" r="86"/>
                        <circle class="cts-ring-fg" data-role="ring" cx="100" cy="100" r="86" stroke="url(#<?php echo esc_attr( $uid ); ?>-g)" stroke-dasharray="540.35" stroke-dashoffset="540.35"/>
                    </svg>
                    <div class="cts-percent"><div><span class="cts-percent-num" data-role="pct">0</span><span class="cts-percent-sym">%</span></div><div class="cts-percent-sub" data-en="Crush Match" data-hi="क्रश मैच">Crush Match</div></div>
                </div>
                <div class="cts-level" data-role="level"></div>
                <p class="cts-rc-desc" data-role="desc"></p>
                <div class="cts-watermark" data-role="wm"></div>
            </div>

            <!-- Metric bars -->
            <div class="cts-bars">
                <div class="cts-bar-row"><div class="cts-bar-top"><span data-en="&#128064; Attraction" data-hi="&#128064; आकर्षण">&#128064; Attraction</span><span data-role="b1-v">0%</span></div><div class="cts-bar"><div class="cts-bar-fill" data-role="b1"></div></div></div>
                <div class="cts-bar-row"><div class="cts-bar-top"><span data-en="&#10024; Chemistry" data-hi="&#10024; केमिस्ट्री">&#10024; Chemistry</span><span data-role="b2-v">0%</span></div><div class="cts-bar"><div class="cts-bar-fill" data-role="b2"></div></div></div>
                <div class="cts-bar-row"><div class="cts-bar-top"><span data-en="&#128172; Connection" data-hi="&#128172; जुड़ाव">&#128172; Connection</span><span data-role="b3-v">0%</span></div><div class="cts-bar"><div class="cts-bar-fill" data-role="b3"></div></div></div>
                <div class="cts-bar-row"><div class="cts-bar-top"><span data-en="&#128293; Spark" data-hi="&#128293; स्पार्क">&#128293; Spark</span><span data-role="b4-v">0%</span></div><div class="cts-bar"><div class="cts-bar-fill" data-role="b4"></div></div></div>
            </div>

            <!-- Extras: emoji / future / soulmate / horoscope -->
            <div class="cts-extras" data-role="extras"></div>

            <!-- Golden hints -->
            <div class="cts-hints">
                <h3>&#11088; <span data-en="Golden Hints" data-hi="गोल्डन हिंट्स">Golden Hints</span></h3>
                <div class="cts-hints-grid" data-role="hints"></div>
            </div>

            <!-- Advice -->
            <div class="cts-advice">
                <h3>&#129302; <span data-en="Your Crush Advice" data-hi="आपके क्रश की सलाह">Your Crush Advice</span></h3>
                <p data-role="advice"></p>
                <div class="cts-tags" data-role="tags"></div>
            </div>

            <!-- Advanced -->
            <div class="cts-adv-panel" data-role="adv-panel">
                <h3>&#128302; <span data-en="Advanced Love Report" data-hi="एडवांस्ड लव रिपोर्ट">Advanced Love Report</span></h3>
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
        <div class="cts-lvl"><div class="cts-lvl-icon">&#128293;</div><h4 data-en="Soulmates" data-hi="सोलमेट्स">Soulmates</h4><div class="cts-lvl-range">90-100%</div><p class="cts-lvl-desc" data-en="Written in stars" data-hi="तारों में लिखा">Written in stars</p></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#128150;</div><h4 data-en="Strong Crush" data-hi="स्ट्रॉन्ग क्रश">Strong Crush</h4><div class="cts-lvl-range">70-89%</div><p class="cts-lvl-desc" data-en="They like you!" data-hi="वे आपको पसंद करते हैं!">They like you!</p></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#128151;</div><h4 data-en="Sweet Spark" data-hi="स्वीट स्पार्क">Sweet Spark</h4><div class="cts-lvl-range">50-69%</div><p class="cts-lvl-desc" data-en="Real potential" data-hi="असली संभावना">Real potential</p></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#128524;</div><h4 data-en="Shy Vibes" data-hi="शाई वाइब्स">Shy Vibes</h4><div class="cts-lvl-range">30-49%</div><p class="cts-lvl-desc" data-en="Take it slow" data-hi="धीरे चलें">Take it slow</p></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#129303;</div><h4 data-en="Friend Zone" data-hi="फ्रेंड ज़ोन">Friend Zone</h4><div class="cts-lvl-range">0-29%</div><p class="cts-lvl-desc" data-en="For now..." data-hi="अभी के लिए...">For now...</p></div>
    </section>

    <!-- Related -->
    <section class="cts-related">
        <h2 data-en="Try More Love Tools" data-hi="और लव टूल्स आज़माएं">Try More Love Tools</h2>
        <div class="cts-related-grid">
            <a class="cts-rt" href="/friendship-calculator/"><div class="cts-rt-icon">&#129309;</div><h4 data-en="Friendship Calculator" data-hi="फ्रेंडशिप कैलकुलेटर">Friendship Calculator</h4><p data-en="How strong is your bond?" data-hi="आपकी दोस्ती कितनी मज़बूत है?">How strong is your bond?</p></a>
            <a class="cts-rt" href="/mulank-calculator/"><div class="cts-rt-icon">&#128302;</div><h4 data-en="Mulank Calculator" data-hi="मूलांक कैलकुलेटर">Mulank Calculator</h4><p data-en="Numerology by date of birth" data-hi="जन्मतिथि से अंक ज्योतिष">Numerology by date of birth</p></a>
            <a class="cts-rt" href="/love-calculator/"><div class="cts-rt-icon">&#10084;</div><h4 data-en="Love Calculator" data-hi="लव कैलकुलेटर">Love Calculator</h4><p data-en="Test your love compatibility" data-hi="लव कम्पैटिबिलिटी जांचें">Test your love compatibility</p></a>
        </div>
    </section>

    <p class="cts-foot" data-en="100% private &middot; just for fun &middot; no data is stored" data-hi="100% प्राइवेट &middot; सिर्फ मनोरंजन हेतु &middot; कोई डेटा सेव नहीं होता">100% private &middot; just for fun &middot; no data is stored</p>

    <script type="application/ld+json">
    {"@context":"https://schema.org","@type":"SoftwareApplication","name":"Crush Calculator","applicationCategory":"LifestyleApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"},"aggregateRating":{"@type":"AggregateRating","ratingValue":"4.9","ratingCount":"10238"}}
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
            steps:['💘 Reading the signals...','🔮 Consulting the stars...','✨ Decoding the vibes...','💌 Revealing the truth...'],
            levels:[{min:90,e:'🔥',n:'Soulmates'},{min:70,e:'💖',n:'Strong Crush'},{min:50,e:'💗',n:'Sweet Spark'},{min:30,e:'😊',n:'Shy Vibes'},{min:0,e:'🤗',n:'Friend Zone'}],
            desc:{
                90:'{a} & {b}, the stars are practically screaming! This is a rare, magnetic connection. Your crush feels the same pull you do — don’t let this spark slip away.',
                70:'{a} & {b}, the signs are strong! There’s real interest here. A little courage and the right moment could turn this crush into something beautiful.',
                50:'{a} & {b}, there’s a sweet spark glowing. The interest is mutual but shy. Spend more time together and let the connection grow naturally.',
                30:'{a} & {b}, the vibe is gentle and warm — but early. Build a friendship first, show your best self, and let feelings bloom in their own time.',
                0:'{a} & {b}, right now the energy says great friends. And honestly? The strongest love stories often begin exactly there. Stay close and stay genuine.'
            },
            hints:{
                hi:[{i:'😏',t:'Make Eye Contact',d:'A confident glance says more than a hundred messages.'},{i:'💬',t:'Start the Talk',d:'Text first about something you both love. Keep it light.'},{i:'🌹',t:'Small Gestures',d:'A tiny thoughtful act melts hearts faster than grand ones.'},{i:'⏰',t:'Pick the Moment',d:'Confess when the vibe is relaxed, not rushed.'}],
                mid:[{i:'😊',t:'Be Genuine',d:'Drop the act — your real self is your best self.'},{i:'🎯',t:'Find Common Ground',d:'Bond over a shared hobby or favourite show.'},{i:'👂',t:'Listen Closely',d:'People fall for those who truly hear them.'},{i:'🌱',t:'Give it Time',d:'Don’t rush. Let the spark grow at its own pace.'}],
                low:[{i:'🤗',t:'Build Friendship',d:'The best romances grow from solid friendships.'},{i:'✨',t:'Shine As You',d:'Focus on being awesome — attraction follows confidence.'},{i:'😄',t:'Stay Light',d:'Make them laugh. Joy is the most attractive trait.'},{i:'💛',t:'No Pressure',d:'Let things unfold naturally. Forcing it never works.'}]
            },
            advice:{
                hi:{text:'{a} & {b}, the chemistry here is undeniable. Be brave — the universe rarely gives such a clear green light. A genuine, well-timed move could start a love story worth remembering.',tags:['Strong Signals','Mutual Vibes','Go For It','Magnetic Pull']},
                mid:{text:'{a} & {b}, something sweet is brewing. Nurture it with honesty, light fun, and patience. Don’t overthink it — just keep showing up as your warm, real self.',tags:['Sweet Spark','Growing Interest','Be Yourself','Stay Patient']},
                low:{text:'{a} & {b}, the timing may not be now, and that’s okay. Build a real friendship, keep your confidence high, and let life surprise you. The right spark always finds its moment.',tags:['Friends First','Stay Confident','Trust Timing','Keep Shining']}
            },
            extras:{
                emojiTitle:'Your Love Emoji', futureTitle:'Future Prediction', soulmateTitle:'Soulmate Sign', horoTitle:'Today’s Love Horoscope',
                emojis:['💖 ✨ 💫','🔥 💘 😍','🌹 💕 😌','💛 🌈 🦋','😎 💗 🎶'],
                futures:['A surprise message changes everything 💌','You two grow closer over a shared moment ☕','A mutual friend plays cupid 🏹','Patience turns a spark into a flame 🔥','A fun outing brings hidden feelings out ✨'],
                soulmates:['Leo ♌ — bold & warm','Libra ♎ — charming & fair','Pisces ♓ — dreamy & kind','Scorpio ♏ — intense & loyal','Gemini ♊ — playful & witty','Taurus ♉ — steady & loving'],
                horos:['Venus favours bold hearts today — make a move 💫','A small kindness today opens a big door 🚪','Speak honestly; the stars reward courage tonight ⭐','Let your guard down — vulnerability is magnetic now 🌙','Good news travels fast in love today 💌']
            },
            advLabels:{compat:'Compatibility Number',element:'Love Element',firstmove:'Who Should Move First',date:'Ideal First Date',odds:'Confession Odds',luckyday:'Lucky Day to Ask'},
            firstMove:{a:'{a} should make the first move 💪',b:'Let {b} take the lead 😌',both:'Make a move together — meet halfway 🤝'},
            dates:['Coffee & a long walk ☕','Movie night 🎬','Sunset by the water 🌅','Street food adventure 🍜','Bookstore & dessert 📚'],
            days:['Friday','Saturday','Sunday','Wednesday'],
            wm:'crush-calculator', share:'💘 Crush Calculator Result!'
        },
        hi: {
            steps:['💘 इशारे पढ़ रहे हैं...','🔮 तारों से पूछ रहे हैं...','✨ वाइब्स डिकोड कर रहे हैं...','💌 सच बता रहे हैं...'],
            levels:[{min:90,e:'🔥',n:'सोलमेट्स'},{min:70,e:'💖',n:'स्ट्रॉन्ग क्रश'},{min:50,e:'💗',n:'स्वीट स्पार्क'},{min:30,e:'😊',n:'शाई वाइब्स'},{min:0,e:'🤗',n:'फ्रेंड ज़ोन'}],
            desc:{
                90:'{a} और {b}, तारे लगभग चिल्ला रहे हैं! यह एक दुर्लभ, चुंबकीय जुड़ाव है। आपका क्रश भी वही खिंचाव महसूस करता है — इस स्पार्क को जाने न दें।',
                70:'{a} और {b}, इशारे मज़बूत हैं! यहां सच्ची दिलचस्पी है। थोड़ी हिम्मत और सही पल इस क्रश को कुछ खूबसूरत बना सकता है।',
                50:'{a} और {b}, एक प्यारा स्पार्क चमक रहा है। दिलचस्पी दोनों तरफ है पर थोड़ी शर्मीली। साथ समय बिताएं, जुड़ाव अपने आप बढ़ेगा।',
                30:'{a} और {b}, वाइब कोमल और गर्म है — पर शुरुआती। पहले दोस्ती बनाएं, अपना बेहतरीन रूप दिखाएं, भावनाएं अपने समय पर खिलेंगी।',
                0:'{a} और {b}, अभी ऊर्जा अच्छे दोस्तों की कहती है। और सच कहें? सबसे मज़बूत प्रेम कहानियां अक्सर यहीं से शुरू होती हैं।'
            },
            hints:{
                hi:[{i:'😏',t:'नज़रें मिलाएं',d:'एक आत्मविश्वासी नज़र सौ मैसेज से ज़्यादा कहती है।'},{i:'💬',t:'बात शुरू करें',d:'किसी पसंदीदा चीज़ पर पहले मैसेज करें। हल्का रखें।'},{i:'🌹',t:'छोटे इशारे',d:'एक छोटा सोचा-समझा काम बड़े से जल्दी दिल पिघलाता है।'},{i:'⏰',t:'सही पल चुनें',d:'जब माहौल शांत हो तभी दिल की बात कहें।'}],
                mid:[{i:'😊',t:'सच्चे रहें',d:'दिखावा छोड़ें — आपका असली रूप सबसे अच्छा है।'},{i:'🎯',t:'समान रुचि',d:'किसी कॉमन शौक या शो पर जुड़ें।'},{i:'👂',t:'ध्यान से सुनें',d:'लोग उन पर फ़िदा होते हैं जो उन्हें सच में सुनते हैं।'},{i:'🌱',t:'वक्त दें',d:'जल्दबाज़ी न करें। स्पार्क को अपनी रफ़्तार से बढ़ने दें।'}],
                low:[{i:'🤗',t:'दोस्ती बनाएं',d:'सबसे अच्छे रोमांस मज़बूत दोस्ती से बढ़ते हैं।'},{i:'✨',t:'खुद चमकें',d:'शानदार बनने पर ध्यान दें — आकर्षण आत्मविश्वास से आता है।'},{i:'😄',t:'हल्के रहें',d:'उन्हें हंसाएं। खुशी सबसे आकर्षक गुण है।'},{i:'💛',t:'कोई दबाव नहीं',d:'चीज़ों को स्वाभाविक रूप से होने दें।'}]
            },
            advice:{
                hi:{text:'{a} और {b}, यहां केमिस्ट्री से इनकार नहीं किया जा सकता। हिम्मत करें — ब्रह्मांड शायद ही इतना साफ हरा संकेत देता है। एक सच्चा, सही समय पर उठाया कदम यादगार प्रेम कहानी शुरू कर सकता है।',tags:['मज़बूत संकेत','दोनों तरफ वाइब','कर दिखाएं','चुंबकीय खिंचाव']},
                mid:{text:'{a} और {b}, कुछ प्यारा पक रहा है। ईमानदारी, हल्की मस्ती और धैर्य से इसे संभालें। ज़्यादा न सोचें — बस अपने गर्म, असली रूप में रहें।',tags:['स्वीट स्पार्क','बढ़ती दिलचस्पी','खुद रहें','धैर्य रखें']},
                low:{text:'{a} और {b}, शायद अभी सही समय नहीं, और यह ठीक है। सच्ची दोस्ती बनाएं, आत्मविश्वास ऊंचा रखें, और ज़िंदगी को चौंकाने दें। सही स्पार्क हमेशा अपना पल ढूंढ लेता है।',tags:['पहले दोस्ती','आत्मविश्वास रखें','समय पर भरोसा','चमकते रहें']}
            },
            extras:{
                emojiTitle:'आपका लव इमोजी', futureTitle:'भविष्यवाणी', soulmateTitle:'सोलमेट राशि', horoTitle:'आज का लव राशिफल',
                emojis:['💖 ✨ 💫','🔥 💘 😍','🌹 💕 😌','💛 🌈 🦋','😎 💗 🎶'],
                futures:['एक अचानक मैसेज सब बदल देगा 💌','किसी साझा पल में आप करीब आएंगे ☕','कोई कॉमन दोस्त कपिड बनेगा 🏹','धैर्य स्पार्क को आग में बदलेगा 🔥','एक मज़ेदार आउटिंग छुपी भावनाएं बाहर लाएगी ✨'],
                soulmates:['सिंह ♌ — साहसी व गर्म','तुला ♎ — आकर्षक व निष्पक्ष','मीन ♓ — स्वप्निल व दयालु','वृश्चिक ♏ — गहन व वफ़ादार','मिथुन ♊ — चंचल व हाज़िरजवाब','वृषभ ♉ — स्थिर व प्रेमी'],
                horos:['आज शुक्र साहसी दिलों के साथ है — कदम बढ़ाएं 💫','आज एक छोटी दयालुता बड़ा दरवाज़ा खोलेगी 🚪','सच बोलें; आज रात तारे साहस को इनाम देंगे ⭐','दिल खोलें — आज कमज़ोरी ही चुंबकीय है 🌙','आज प्यार में अच्छी खबर तेज़ी से फैलेगी 💌']
            },
            advLabels:{compat:'कम्पैटिबिलिटी नंबर',element:'लव तत्व',firstmove:'पहला कदम कौन उठाए',date:'आदर्श पहली डेट',odds:'इज़हार की संभावना',luckyday:'पूछने का शुभ दिन'},
            firstMove:{a:'{a} को पहला कदम उठाना चाहिए 💪',b:'{b} को आगे बढ़ने दें 😌',both:'साथ कदम बढ़ाएं — बीच में मिलें 🤝'},
            dates:['कॉफी और लंबी सैर ☕','मूवी नाइट 🎬','पानी के पास सनसेट 🌅','स्ट्रीट फूड एडवेंचर 🍜','बुकस्टोर और डेज़र्ट 📚'],
            days:['शुक्रवार','शनिवार','रविवार','बुधवार'],
            wm:'crush-calculator', share:'💘 क्रश कैलकुलेटर रिज़ल्ट!'
        }
    };

    var ELEMENTS={en:['Fire 🔥','Water 💧','Air 🌬','Earth 🌍'],hi:['अग्नि 🔥','जल 💧','वायु 🌬','पृथ्वी 🌍']};

    function clean(s){ return (s||'').toLowerCase().replace(/[^a-zऀ-ॿ]/g,''); }
    function score(n1,n2){
        var a=clean(n1),b=clean(n2);
        if (!a||!b){ return 50; }
        var sa=0,sb=0,i;
        for (i=0;i<a.length;i++){ sa+=a.charCodeAt(i); }
        for (i=0;i<b.length;i++){ sb+=b.charCodeAt(i); }
        var fa={},fb={},k,ov=0,tot=0;
        for (i=0;i<a.length;i++){ fa[a[i]]=(fa[a[i]]||0)+1; }
        for (i=0;i<b.length;i++){ fb[b[i]]=(fb[b[i]]||0)+1; }
        var keys={}; for (k in fa){ keys[k]=1; } for (k in fb){ keys[k]=1; }
        for (k in keys){ ov+=Math.min(fa[k]||0,fb[k]||0); tot+=Math.max(fa[k]||0,fb[k]||0); }
        var overlap=tot?(ov/tot)*100:50;
        var num=C.reduceDigit(sa+sb)*10;
        var sd=C.seed(a+'<3'+b);
        var rand=Math.abs(Math.sin(sd))*32;
        var raw=overlap*0.34+num*0.22+rand*0.7+18;
        var sc=Math.round(raw);
        if (sc<14){ sc=14+(Math.abs(sd)%22); }
        if (sc>99){ sc=99; }
        return sc;
    }
    function metrics(n1,n2,sc){
        var sd=C.seed(clean(n1)+'*'+clean(n2));
        function v(off){ var r=Math.abs(Math.sin(sd+off))*22-11; return Math.max(18,Math.min(99,Math.round(sc+r))); }
        return {b1:v(1),b2:v(2),b3:v(3),b4:v(4)};
    }
    function levelFor(sc){ var L=T[lang].levels; for (var i=0;i<L.length;i++){ if (sc>=L[i].min){ return L[i]; } } return L[L.length-1]; }
    function tier(sc){ return sc>=70?'hi':(sc>=40?'mid':'low'); }
    function band(sc){ return sc>=90?90:sc>=70?70:sc>=50?50:sc>=30?30:0; }

    var state={};

    function render(){
        var t=T[lang], n1=state.n1, n2=state.n2, sc=state.sc, m=state.m;
        var lvl=levelFor(sc), tr=tier(sc), sd=C.seed(clean(n1)+clean(n2));
        $('rc-n-a').textContent=n1; $('rc-n-b').textContent=n2;
        $('rc-av-a').textContent=n1.charAt(0).toUpperCase();
        $('rc-av-b').textContent=n2.charAt(0).toUpperCase();
        $('level').textContent=lvl.e+' '+lvl.n;
        $('desc').textContent=t.desc[band(sc)].replace('{a}',n1).replace('{b}',n2);
        $('wm').textContent=t.wm+' 💘';

        C.animateNum($('pct'),0,sc,1700);
        var circ=2*Math.PI*86;
        setTimeout(function(){ $('ring').style.strokeDashoffset=circ-(circ*sc/100); },80);
        setTimeout(function(){
            $('b1').style.width=m.b1+'%'; $('b2').style.width=m.b2+'%'; $('b3').style.width=m.b3+'%'; $('b4').style.width=m.b4+'%';
            $('b1-v').textContent=m.b1+'%'; $('b2-v').textContent=m.b2+'%'; $('b3-v').textContent=m.b3+'%'; $('b4-v').textContent=m.b4+'%';
        },200);

        var ex=t.extras;
        var cards=[
            {e:'😍',ti:ex.emojiTitle,v:C.pick(ex.emojis,sd,1)},
            {e:'🔮',ti:ex.futureTitle,v:C.pick(ex.futures,sd,2)},
            {e:'💞',ti:ex.soulmateTitle,v:C.pick(ex.soulmates,sd,3)},
            {e:'⭐',ti:ex.horoTitle,v:C.pick(ex.horos,sd,4)}
        ];
        var eg=$('extras'); eg.innerHTML='';
        cards.forEach(function(c,i){
            var d=document.createElement('div'); d.className='cts-x'; d.style.animationDelay=(i*0.08)+'s';
            d.innerHTML='<div class="cts-x-head"><span class="cts-x-emoji">'+c.e+'</span><span class="cts-x-title">'+C.escapeHtml(c.ti)+'</span></div><p class="cts-x-val">'+C.escapeHtml(c.v)+'</p>';
            eg.appendChild(d);
        });

        var hints=t.hints[tr], hg=$('hints'); hg.innerHTML='';
        hints.forEach(function(h,i){
            var d=document.createElement('div'); d.className='cts-hint'; d.style.animationDelay=(i*0.1)+'s';
            d.innerHTML='<div class="cts-hint-icon">'+h.i+'</div><h4>'+C.escapeHtml(h.t)+'</h4><p>'+C.escapeHtml(h.d)+'</p>';
            hg.appendChild(d);
        });

        var adv=t.advice[tr];
        $('advice').textContent=adv.text.replace('{a}',n1).replace('{b}',n2);
        var tags=$('tags'); tags.innerHTML='';
        adv.tags.forEach(function(tg){ var s=document.createElement('span'); s.className='cts-tag'; s.textContent=tg; tags.appendChild(s); });

        // advanced
        var al=t.advLabels;
        var fmKey=(Math.abs(C.seed(n1))%3); var fm=fmKey===0?t.firstMove.a.replace('{a}',n1):(fmKey===1?t.firstMove.b.replace('{b}',n2):t.firstMove.both);
        var advData=[
            [al.compat, C.reduceDigit(C.seed(clean(n1))+C.seed(clean(n2)))],
            [al.element, C.pick(ELEMENTS[lang],sd,5)],
            [al.firstmove, fm],
            [al.date, C.pick(t.dates,sd,6)],
            [al.odds, sc+'%'],
            [al.luckyday, C.pick(t.days,sd,7)]
        ];
        var ag=$('adv-grid'); ag.innerHTML='';
        advData.forEach(function(p){ var d=document.createElement('div'); d.className='cts-adv-item'; d.innerHTML='<div class="k">'+C.escapeHtml(p[0])+'</div><div class="v">'+C.escapeHtml(String(p[1]))+'</div>'; ag.appendChild(d); });
        if (root.classList.contains('cts-adv-active')) { $('adv-panel').classList.add('cts-show'); }

        var url=window.location.href;
        var msg=t.share+'\n\n'+n1+' 💘 '+n2+' = '+sc+'%\n'+lvl.e+' '+lvl.n+'\n\n'+url;
        $('wa').href=C.shareWhatsApp(msg);
        $('tw').href=C.shareTwitter(n1+' 💘 '+n2+' = '+sc+'% '+lvl.n, url);

        if (sc>=70){ setTimeout(C.confetti,600); }
        setTimeout(function(){ $('result').scrollIntoView({behavior:'smooth',block:'start'}); },100);
    }

    function go(){
        var n1=($('name-a').value||'').trim(), n2=($('name-b').value||'').trim(), err=$('error');
        if (!n1||!n2){ err.classList.add('cts-show'); return; }
        if (n1.length<2||n2.length<2){ err.textContent=lang==='hi'?'नाम कम से कम 2 अक्षर का हो।':'Names should be at least 2 characters.'; err.classList.add('cts-show'); return; }
        err.classList.remove('cts-show');
        state.n1=n1; state.n2=n2; state.sc=score(n1,n2); state.m=metrics(n1,n2,state.sc);
        $('input').style.display='none';
        var ld=$('loading'); ld.style.display='block'; ld.classList.add('cts-show');
        $('load-title').textContent=n1+' 💘 '+n2;
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
            brand:'Crush Calculator', title:state.n1+' & '+state.n2,
            percent:state.sc, centerText:state.sc+'%', centerSub:lang==='hi'?'क्रश मैच':'Crush Match',
            level:lvl.e+' '+lvl.n, desc:T[lang].desc[band(state.sc)].replace('{a}',state.n1).replace('{b}',state.n2),
            footer:'crush-calculator', file:'crush-'+state.sc
        });
        if (!ok){ alert(lang==='hi'?'स्क्रीनशॉट लेकर सेव करें!':'Take a screenshot to save your result!'); }
    });

    C.qa(root,'.cts-seg').forEach(function(btn){
        btn.addEventListener('click',function(){
            lang=btn.getAttribute('data-lang');
            C.qa(root,'.cts-seg').forEach(function(x){ x.classList.toggle('cts-on', x===btn); });
            C.applyLang(root,lang);
            if ($('result').classList.contains('cts-show')){ render(); }
        });
    });

    $('adv-toggle').addEventListener('click',function(){
        var on=root.classList.toggle('cts-adv-active');
        this.classList.toggle('cts-on',on);
        if ($('result').classList.contains('cts-show')){ $('adv-panel').classList.toggle('cts-show',on); }
    });

    C.applyLang(root,'en');
    C.liveCounter($('counter'),312760);
})();
</script>
        <?php
        return ob_get_clean();
    }

    add_shortcode( 'crush_calculator', 'cts_crush_render' );
}
