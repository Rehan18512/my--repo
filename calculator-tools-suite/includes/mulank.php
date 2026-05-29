<?php
/**
 * Mulank & Bhagyank Calculator  ->  shortcode [mulank_calculator]
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'cts_mulank_render' ) ) {

    function cts_mulank_render( $atts = array() ) {
        $uid = 'mk-' . wp_rand( 1000, 9999 );
        $today = gmdate( 'Y-m-d' );
        ob_start();
        echo cts_shared_assets(); // phpcs:ignore WordPress.Security.EscapeOutput
        ?>
<div class="cts-wrap cts-mulank" id="<?php echo esc_attr( $uid ); ?>" data-tool="mulank">

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
        <div class="cts-h-icon">&#128302;</div>
        <h1 data-en="Mulank &amp; Bhagyank Calculator" data-hi="मूलांक एवं भाग्यांक कैलकुलेटर">Mulank &amp; Bhagyank Calculator</h1>
        <p class="cts-h-sub" data-en="Reveal your numerology numbers from your date of birth" data-hi="अपनी जन्मतिथि से अंक ज्योतिष जानें">Reveal your numerology numbers from your date of birth</p>
        <div class="cts-stats">
            <div class="cts-stat"><div class="cts-stat-num" data-role="counter">1,94,830</div><div class="cts-stat-lbl" data-en="Readings Today" data-hi="आज रीडिंग">Readings Today</div></div>
            <div class="cts-stat"><div class="cts-stat-num">4.9&#9733;</div><div class="cts-stat-lbl" data-en="Rating" data-hi="रेटिंग">Rating</div></div>
            <div class="cts-stat"><div class="cts-stat-num">100%</div><div class="cts-stat-lbl" data-en="Free" data-hi="फ्री">Free</div></div>
        </div>
    </header>

    <section class="cts-card">
        <!-- Input -->
        <div data-role="input">
            <div class="cts-single">
                <label class="cts-label" data-en="Enter your Date of Birth" data-hi="अपनी जन्मतिथि दर्ज करें">Enter your Date of Birth</label>
                <input type="date" class="cts-input" data-role="dob" max="<?php echo esc_attr( $today ); ?>" min="1920-01-01" />
                <label class="cts-label" data-en="Your name (optional)" data-hi="आपका नाम (वैकल्पिक)">Your name (optional)</label>
                <input type="text" class="cts-input" data-role="name" maxlength="30" autocomplete="off" placeholder="Your name" data-ph-en="Your name" data-ph-hi="आपका नाम" />
            </div>
            <div class="cts-error" data-role="error" data-en="Please select a valid date of birth." data-hi="कृपया सही जन्मतिथि चुनें।">Please select a valid date of birth.</div>
            <button type="button" class="cts-btn cts-btn-primary" data-role="calc" data-en="Calculate My Numbers &#128302;" data-hi="मेरे अंक निकालें &#128302;">Calculate My Numbers &#128302;</button>
            <div class="cts-trust">
                <span data-en="&#128274; Private" data-hi="&#128274; प्राइवेट">&#128274; Private</span>
                <span data-en="&#9889; Instant" data-hi="&#9889; इंस्टेंट">&#9889; Instant</span>
                <span data-en="&#128214; Vedic Numerology" data-hi="&#128214; वैदिक अंक ज्योतिष">&#128214; Vedic Numerology</span>
            </div>
        </div>

        <!-- Loading -->
        <div class="cts-loading" data-role="loading">
            <div class="cts-rings"><div class="cts-ring"></div><div class="cts-ring"></div><div class="cts-ring"></div><div class="cts-ring-emoji">&#128302;</div></div>
            <div class="cts-load-title" data-role="load-title">&#128302;</div>
            <div class="cts-load-step" data-role="load-step"></div>
            <div class="cts-progress"><div class="cts-progress-bar" data-role="bar"></div></div>
        </div>

        <!-- Result -->
        <div class="cts-result" data-role="result">
            <div class="cts-rcard">
                <div class="cts-ring-wrap">
                    <svg viewBox="0 0 200 200" aria-hidden="true">
                        <defs><linearGradient id="<?php echo esc_attr( $uid ); ?>-g" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#f4c430"/><stop offset="100%" stop-color="#b558d6"/></linearGradient></defs>
                        <circle class="cts-ring-bg" cx="100" cy="100" r="86"/>
                        <circle class="cts-ring-fg" data-role="ring" cx="100" cy="100" r="86" stroke="url(#<?php echo esc_attr( $uid ); ?>-g)" stroke-dasharray="540.35" stroke-dashoffset="540.35"/>
                    </svg>
                    <div class="cts-percent"><div><span class="cts-percent-num" data-role="mulank">0</span></div><div class="cts-percent-sub" data-en="Mulank" data-hi="मूलांक">Mulank</div></div>
                </div>
                <div class="cts-level" data-role="level"></div>
                <p class="cts-rc-desc" data-role="desc"></p>
                <div class="cts-watermark" data-role="wm"></div>
            </div>

            <!-- Number chips -->
            <div class="cts-extras" data-role="numbers"></div>

            <!-- Strength bars -->
            <div class="cts-bars">
                <div class="cts-bar-row"><div class="cts-bar-top"><span data-en="&#128081; Leadership" data-hi="&#128081; नेतृत्व">&#128081; Leadership</span><span data-role="b1-v">0%</span></div><div class="cts-bar"><div class="cts-bar-fill" data-role="b1"></div></div></div>
                <div class="cts-bar-row"><div class="cts-bar-top"><span data-en="&#127912; Creativity" data-hi="&#127912; रचनात्मकता">&#127912; Creativity</span><span data-role="b2-v">0%</span></div><div class="cts-bar"><div class="cts-bar-fill" data-role="b2"></div></div></div>
                <div class="cts-bar-row"><div class="cts-bar-top"><span data-en="&#127808; Luck" data-hi="&#127808; भाग्य">&#127808; Luck</span><span data-role="b3-v">0%</span></div><div class="cts-bar"><div class="cts-bar-fill" data-role="b3"></div></div></div>
                <div class="cts-bar-row"><div class="cts-bar-top"><span data-en="&#129309; Relationships" data-hi="&#129309; रिश्ते">&#129309; Relationships</span><span data-role="b4-v">0%</span></div><div class="cts-bar"><div class="cts-bar-fill" data-role="b4"></div></div></div>
            </div>

            <!-- Lucky extras -->
            <div class="cts-extras" data-role="lucky"></div>

            <!-- Golden hints / remedies -->
            <div class="cts-hints">
                <h3>&#11088; <span data-en="Golden Tips &amp; Remedies" data-hi="गोल्डन टिप्स एवं उपाय">Golden Tips &amp; Remedies</span></h3>
                <div class="cts-hints-grid" data-role="hints"></div>
            </div>

            <!-- Advice -->
            <div class="cts-advice">
                <h3>&#129302; <span data-en="Numerology Guidance" data-hi="अंक ज्योतिष मार्गदर्शन">Numerology Guidance</span></h3>
                <p data-role="advice"></p>
                <div class="cts-tags" data-role="tags"></div>
            </div>

            <!-- Advanced -->
            <div class="cts-adv-panel" data-role="adv-panel">
                <h3>&#128302; <span data-en="Advanced Numerology Report" data-hi="एडवांस्ड अंक ज्योतिष रिपोर्ट">Advanced Numerology Report</span></h3>
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

    <!-- Number guide -->
    <section class="cts-levels">
        <div class="cts-lvl"><div class="cts-lvl-icon">&#9728;</div><h4 data-en="1 &middot; Sun" data-hi="1 &middot; सूर्य">1 &middot; Sun</h4><div class="cts-lvl-range" data-en="Leader" data-hi="नेता">Leader</div></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#127769;</div><h4 data-en="2 &middot; Moon" data-hi="2 &middot; चंद्र">2 &middot; Moon</h4><div class="cts-lvl-range" data-en="Gentle" data-hi="कोमल">Gentle</div></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#129518;</div><h4 data-en="3 &middot; Jupiter" data-hi="3 &middot; गुरु">3 &middot; Jupiter</h4><div class="cts-lvl-range" data-en="Wise" data-hi="ज्ञानी">Wise</div></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#127756;</div><h4 data-en="4 &middot; Rahu" data-hi="4 &middot; राहु">4 &middot; Rahu</h4><div class="cts-lvl-range" data-en="Rebel" data-hi="विद्रोही">Rebel</div></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#128172;</div><h4 data-en="5 &middot; Mercury" data-hi="5 &middot; बुध">5 &middot; Mercury</h4><div class="cts-lvl-range" data-en="Clever" data-hi="चतुर">Clever</div></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#10084;</div><h4 data-en="6 &middot; Venus" data-hi="6 &middot; शुक्र">6 &middot; Venus</h4><div class="cts-lvl-range" data-en="Loving" data-hi="प्रेमी">Loving</div></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#128302;</div><h4 data-en="7 &middot; Ketu" data-hi="7 &middot; केतु">7 &middot; Ketu</h4><div class="cts-lvl-range" data-en="Mystic" data-hi="रहस्यमय">Mystic</div></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#9889;</div><h4 data-en="8 &middot; Saturn" data-hi="8 &middot; शनि">8 &middot; Saturn</h4><div class="cts-lvl-range" data-en="Worker" data-hi="कर्मठ">Worker</div></div>
        <div class="cts-lvl"><div class="cts-lvl-icon">&#128293;</div><h4 data-en="9 &middot; Mars" data-hi="9 &middot; मंगल">9 &middot; Mars</h4><div class="cts-lvl-range" data-en="Warrior" data-hi="योद्धा">Warrior</div></div>
    </section>

    <!-- Related -->
    <section class="cts-related">
        <h2 data-en="Try More Calculators" data-hi="और कैलकुलेटर आज़माएं">Try More Calculators</h2>
        <div class="cts-related-grid">
            <a class="cts-rt" href="/friendship-calculator/"><div class="cts-rt-icon">&#129309;</div><h4 data-en="Friendship Calculator" data-hi="फ्रेंडशिप कैलकुलेटर">Friendship Calculator</h4><p data-en="How strong is your bond?" data-hi="आपकी दोस्ती कितनी मज़बूत है?">How strong is your bond?</p></a>
            <a class="cts-rt" href="/crush-calculator/"><div class="cts-rt-icon">&#128150;</div><h4 data-en="Crush Calculator" data-hi="क्रश कैलकुलेटर">Crush Calculator</h4><p data-en="Does your crush like you?" data-hi="क्या आपका क्रश आपको पसंद करता है?">Does your crush like you?</p></a>
            <a class="cts-rt" href="/love-calculator/"><div class="cts-rt-icon">&#10084;</div><h4 data-en="Love Calculator" data-hi="लव कैलकुलेटर">Love Calculator</h4><p data-en="Test love compatibility" data-hi="लव कम्पैटिबिलिटी जांचें">Test love compatibility</p></a>
        </div>
    </section>

    <p class="cts-foot" data-en="Based on Vedic numerology &middot; 100% private &middot; for guidance &amp; fun" data-hi="वैदिक अंक ज्योतिष पर आधारित &middot; 100% प्राइवेट &middot; मार्गदर्शन एवं मनोरंजन हेतु">Based on Vedic numerology &middot; 100% private &middot; for guidance &amp; fun</p>

    <script type="application/ld+json">
    {"@context":"https://schema.org","@type":"SoftwareApplication","name":"Mulank and Bhagyank Calculator","applicationCategory":"LifestyleApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"},"aggregateRating":{"@type":"AggregateRating","ratingValue":"4.9","ratingCount":"7630"}}
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

    // Numerology data 1..9
    var DATA = {
        en: {
            steps:['🔢 Reading your date of birth...','🪐 Mapping your ruling planet...','✨ Decoding your destiny...','📜 Preparing your report...'],
            mulankLbl:'Mulank', bhagyankLbl:'Bhagyank', planetLbl:'Ruling Planet',
            n:{
                1:{planet:'Sun (Surya)',title:'The Natural Leader',desc:'You are a born leader — bold, independent and ambitious. People naturally look up to you. Your willpower can move mountains when you stay focused.',color:'Golden / Orange',day:'Sunday',gem:'Ruby',career:'Leadership, Government, Business, Administration',dir:'East',element:'Fire',friends:'1, 2, 3, 9',tough:'8, 4',mantra:'Om Suryaya Namah',keywords:['Leadership','Confidence','Ambition','Originality'],
                    hints:[{i:'🌅',t:'Greet the Sun',d:'Offer water to the rising sun on Sundays to boost energy.'},{i:'🟡',t:'Wear Gold tones',d:'Yellow & golden shades amplify your natural charisma.'},{i:'🎯',t:'Lead, don’t dominate',d:'Your power grows when you lift others, not control them.'},{i:'🌞',t:'Sunday is yours',d:'Start big plans on Sunday for the best outcomes.'}],
                    advice:'Your number is ruled by the Sun — the king of all planets. Lead with warmth and humility and success will follow you everywhere.'},
                2:{planet:'Moon (Chandra)',title:'The Gentle Soul',desc:'You are emotional, intuitive and caring. You read people effortlessly and bring peace wherever you go. Your sensitivity is a superpower, not a weakness.',color:'White / Cream / Silver',day:'Monday',gem:'Pearl',career:'Counselling, Arts, Healthcare, Hospitality',dir:'North-West',element:'Water',friends:'1, 2, 4, 7',tough:'8, 9',mantra:'Om Chandraya Namah',keywords:['Intuition','Empathy','Diplomacy','Calm'],
                    hints:[{i:'🌝',t:'Honour the Moon',d:'Keep a small silver item with you for emotional balance.'},{i:'🤍',t:'Wear soft whites',d:'White & cream shades soothe your sensitive nature.'},{i:'🧘',t:'Guard your energy',d:'Meditate often — your moods rise and fall like tides.'},{i:'💧',t:'Stay near water',d:'Time near rivers or the sea recharges your spirit.'}],
                    advice:'The Moon makes you deeply intuitive. Trust your gut feelings — they are rarely wrong. Protect your peace and your gifts will shine.'},
                3:{planet:'Jupiter (Guru)',title:'The Wise Optimist',desc:'You are wise, cheerful and full of knowledge. Teaching, guiding and inspiring come naturally. Your optimism lights up every room you enter.',color:'Yellow',day:'Thursday',gem:'Yellow Sapphire',career:'Teaching, Law, Writing, Spirituality, Finance',dir:'North-East',element:'Ether',friends:'3, 6, 9',tough:'6 (excess)',mantra:'Om Brihaspataye Namah',keywords:['Wisdom','Optimism','Discipline','Generosity'],
                    hints:[{i:'📚',t:'Keep learning',d:'A new skill each year keeps your lucky planet strong.'},{i:'💛',t:'Wear yellow',d:'Yellow on Thursdays attracts wisdom and wealth.'},{i:'🙏',t:'Give back',d:'Donate or teach — generosity multiplies your luck.'},{i:'🪔',t:'Respect elders',d:'Blessings from elders and teachers fuel your growth.'}],
                    advice:'Jupiter blesses you with wisdom and luck. Share your knowledge freely and the universe will keep refilling your cup.'},
                4:{planet:'Rahu (Uranus)',title:'The Unconventional Mind',desc:'You think differently and see what others miss. Rules feel limiting to you. Channel your rebel energy into innovation and you become unstoppable.',color:'Grey / Electric Blue',day:'Saturday',gem:'Hessonite (Gomed)',career:'Technology, Research, Innovation, Engineering',dir:'South-West',element:'Air',friends:'1, 2, 7, 8',tough:'5',mantra:'Om Rahave Namah',keywords:['Innovation','Courage','Uniqueness','Resilience'],
                    hints:[{i:'⚙️',t:'Build something new',d:'Your mind thrives on solving unusual problems.'},{i:'🔵',t:'Choose blue-grey',d:'Cool tones steady your restless energy.'},{i:'🧱',t:'Create structure',d:'Routines turn your wild ideas into real results.'},{i:'🌌',t:'Trust the unusual',d:'The path others avoid is often where you win.'}],
                    advice:'Rahu gives you a rare, original mind. Embrace your uniqueness — what makes you different is exactly what makes you powerful.'},
                5:{planet:'Mercury (Budh)',title:'The Clever Communicator',desc:'You are quick, witty and adaptable. Business and communication are your playgrounds. You can talk your way into any opportunity and out of any trouble.',color:'Green',day:'Wednesday',gem:'Emerald',career:'Business, Marketing, Media, Trading, Sales',dir:'North',element:'Earth',friends:'5, 6, 9, 1',tough:'4',mantra:'Om Budhaya Namah',keywords:['Communication','Adaptability','Wit','Charm'],
                    hints:[{i:'💬',t:'Use your voice',d:'Speak up — words are your strongest superpower.'},{i:'💚',t:'Wear green',d:'Green on Wednesdays sharpens your mind & deals.'},{i:'📈',t:'Trade smart',d:'Your instinct for business is gold — act on it.'},{i:'🧠',t:'Stay flexible',d:'Adapt fast and you will always land on your feet.'}],
                    advice:'Mercury gifts you charm and a sharp mind. Use your words to build bridges, not walls, and doors will open everywhere.'},
                6:{planet:'Venus (Shukra)',title:'The Lover of Beauty',desc:'You are charming, artistic and deeply loving. Beauty, harmony and relationships matter most to you. People are naturally drawn to your warmth.',color:'White / Sky Blue / Pink',day:'Friday',gem:'Diamond / Opal',career:'Art, Design, Fashion, Hospitality, Entertainment',dir:'South-East',element:'Water',friends:'3, 6, 9',tough:'8',mantra:'Om Shukraya Namah',keywords:['Love','Charm','Creativity','Harmony'],
                    hints:[{i:'🌸',t:'Surround with beauty',d:'A beautiful space lifts your mood and luck.'},{i:'🤍',t:'Wear pastels',d:'Soft pinks & whites magnify your magnetic charm.'},{i:'🎨',t:'Create art',d:'Express yourself — creativity is your fuel.'},{i:'💝',t:'Love generously',d:'Your relationships are your greatest treasure.'}],
                    advice:'Venus blesses you with love and beauty. Lead with your heart, create freely, and let your warmth attract the right people.'},
                7:{planet:'Ketu (Neptune)',title:'The Spiritual Seeker',desc:'You are introspective, mystical and wise beyond your years. You seek deeper meaning in everything. Solitude recharges you and intuition guides you.',color:'White / Light Green',day:'Monday',gem:'Cat\'s Eye',career:'Research, Spirituality, Psychology, Writing, Healing',dir:'West',element:'Water',friends:'2, 4, 7',tough:'1',mantra:'Om Ketave Namah',keywords:['Intuition','Wisdom','Mystery','Depth'],
                    hints:[{i:'🧘',t:'Embrace solitude',d:'Quiet time unlocks your deepest insights.'},{i:'🤍',t:'Wear white',d:'White & light tones calm your active mind.'},{i:'📿',t:'Practice spirituality',d:'Meditation or prayer aligns your energy.'},{i:'🌙',t:'Trust intuition',d:'Your inner voice knows before your mind does.'}],
                    advice:'Ketu makes you an old soul. Honour your need for depth and solitude — your wisdom is a gift the noisy world badly needs.'},
                8:{planet:'Saturn (Shani)',title:'The Disciplined Achiever',desc:'You are hardworking, patient and destined for big success — earned slowly but solidly. Saturn tests you, then rewards you richly. Discipline is your magic.',color:'Dark Blue / Black',day:'Saturday',gem:'Blue Sapphire',career:'Law, Finance, Real Estate, Leadership, Engineering',dir:'West',element:'Air',friends:'4, 8, 5',tough:'1, 2',mantra:'Om Shanaye Namah',keywords:['Discipline','Patience','Justice','Endurance'],
                    hints:[{i:'⏳',t:'Be patient',d:'Your rewards come later — but they come big.'},{i:'🔵',t:'Wear dark blue',d:'Deep blues steady your focus and karma.'},{i:'⚖️',t:'Stay honest',d:'Saturn rewards integrity above all else.'},{i:'🛠',t:'Work hard quietly',d:'Consistent effort beats luck for you every time.'}],
                    advice:'Saturn is a strict but fair teacher. Stay disciplined and ethical — every bit of honest effort you make is being recorded and rewarded.'},
                9:{planet:'Mars (Mangal)',title:'The Fearless Warrior',desc:'You are energetic, brave and passionate. You fight for what is right and never give up. Your courage inspires everyone around you to be bolder.',color:'Red / Coral',day:'Tuesday',gem:'Red Coral',career:'Defence, Sports, Surgery, Engineering, Leadership',dir:'South',element:'Fire',friends:'3, 6, 9',tough:'2',mantra:'Om Mangalaya Namah',keywords:['Courage','Energy','Passion','Loyalty'],
                    hints:[{i:'🔥',t:'Channel your fire',d:'Exercise daily to burn off restless energy.'},{i:'🔴',t:'Wear red',d:'Red on Tuesdays boosts your courage & drive.'},{i:'🧯',t:'Tame your temper',d:'Pause before reacting — your power needs control.'},{i:'🏆',t:'Aim high',d:'You were built to win — set bold goals.'}],
                    advice:'Mars fills you with fire and courage. Direct that energy with patience and you will conquer every challenge life throws at you.'}
            },
            luckyT:{color:'Lucky Color',day:'Lucky Day',num:'Lucky Numbers',gem:'Lucky Gemstone'},
            advLabels:{mulank:'Mulank (Root)',bhagyank:'Bhagyank (Destiny)',planet:'Ruling Planet',friends:'Friendly Numbers',tough:'Challenging Numbers',dir:'Lucky Direction',element:'Element',mantra:'Beej Mantra',career:'Ideal Careers'},
            barLbl:['Leadership','Creativity','Luck','Relationships'],
            wm:'mulank-calculator'
        },
        hi: {
            steps:['🔢 आपकी जन्मतिथि पढ़ रहे हैं...','🪐 आपका स्वामी ग्रह देख रहे हैं...','✨ आपका भाग्य खोल रहे हैं...','📜 रिपोर्ट तैयार हो रही है...'],
            mulankLbl:'मूलांक', bhagyankLbl:'भाग्यांक', planetLbl:'स्वामी ग्रह',
            n:{
                1:{planet:'सूर्य',title:'जन्मजात नेता',desc:'आप एक जन्मजात नेता हैं — साहसी, स्वतंत्र और महत्वाकांक्षी। लोग स्वाभाविक रूप से आपका अनुसरण करते हैं। आपकी इच्छाशक्ति पहाड़ हिला सकती है।',color:'सुनहरा / नारंगी',day:'रविवार',gem:'माणिक (Ruby)',career:'नेतृत्व, सरकारी सेवा, व्यापार, प्रशासन',dir:'पूर्व',element:'अग्नि',friends:'1, 2, 3, 9',tough:'8, 4',mantra:'ॐ सूर्याय नमः',keywords:['नेतृत्व','आत्मविश्वास','महत्वाकांक्षा','मौलिकता'],
                    hints:[{i:'🌅',t:'सूर्य को अर्घ्य',d:'रविवार को उगते सूर्य को जल चढ़ाएं — ऊर्जा बढ़ेगी।'},{i:'🟡',t:'सुनहरे रंग पहनें',d:'पीला व सुनहरा रंग आपका आकर्षण बढ़ाता है।'},{i:'🎯',t:'नेतृत्व करें',d:'दूसरों को ऊपर उठाएं, नियंत्रण न करें — शक्ति बढ़ेगी।'},{i:'🌞',t:'रविवार शुभ',d:'बड़े काम रविवार को शुरू करें।'}],
                    advice:'आपका अंक सूर्य द्वारा शासित है — सभी ग्रहों का राजा। विनम्रता से नेतृत्व करें, सफलता हर जगह आपका पीछा करेगी।'},
                2:{planet:'चंद्र',title:'कोमल हृदय',desc:'आप भावुक, सहज-ज्ञानी और देखभाल करने वाले हैं। आप लोगों को आसानी से पढ़ लेते हैं और शांति लाते हैं। आपकी संवेदनशीलता एक शक्ति है।',color:'सफेद / क्रीम / चांदी',day:'सोमवार',gem:'मोती (Pearl)',career:'काउंसलिंग, कला, स्वास्थ्य, आतिथ्य',dir:'वायव्य',element:'जल',friends:'1, 2, 4, 7',tough:'8, 9',mantra:'ॐ चंद्राय नमः',keywords:['अंतर्ज्ञान','सहानुभूति','कूटनीति','शांति'],
                    hints:[{i:'🌝',t:'चंद्र का सम्मान',d:'भावनात्मक संतुलन हेतु चांदी की वस्तु रखें।'},{i:'🤍',t:'सफेद पहनें',d:'सफेद व क्रीम रंग आपके मन को शांत करते हैं।'},{i:'🧘',t:'ऊर्जा बचाएं',d:'ध्यान करें — आपका मन लहरों जैसा बदलता है।'},{i:'💧',t:'जल के पास रहें',d:'नदी या समुद्र के पास समय बिताएं।'}],
                    advice:'चंद्र आपको गहरा अंतर्ज्ञान देता है। अपनी अंदरूनी आवाज़ पर भरोसा करें — वह शायद ही गलत होती है।'},
                3:{planet:'गुरु (बृहस्पति)',title:'ज्ञानी आशावादी',desc:'आप बुद्धिमान, प्रसन्न और ज्ञान से भरपूर हैं। सिखाना और प्रेरित करना आपका स्वभाव है। आपका आशावाद हर जगह उजाला फैलाता है।',color:'पीला',day:'गुरुवार',gem:'पुखराज (Yellow Sapphire)',career:'शिक्षण, कानून, लेखन, अध्यात्म, वित्त',dir:'ईशान',element:'आकाश',friends:'3, 6, 9',tough:'6 (अधिकता)',mantra:'ॐ बृहस्पतये नमः',keywords:['ज्ञान','आशावाद','अनुशासन','उदारता'],
                    hints:[{i:'📚',t:'सीखते रहें',d:'हर साल नया कौशल आपके भाग्य ग्रह को मज़बूत रखता है।'},{i:'💛',t:'पीला पहनें',d:'गुरुवार को पीला रंग ज्ञान व धन लाता है।'},{i:'🙏',t:'दान करें',d:'दान या शिक्षा देना भाग्य को कई गुना बढ़ाता है।'},{i:'🪔',t:'बड़ों का सम्मान',d:'गुरुजनों का आशीर्वाद आपको आगे बढ़ाता है।'}],
                    advice:'गुरु आपको ज्ञान और भाग्य देता है। अपना ज्ञान खुलकर बांटें, ब्रह्मांड आपका पात्र भरता रहेगा।'},
                4:{planet:'राहु',title:'अनोखी सोच',desc:'आप अलग सोचते हैं और वह देखते हैं जो दूसरे चूक जाते हैं। नियम आपको सीमित लगते हैं। अपनी विद्रोही ऊर्जा को नवाचार में लगाएं।',color:'धूसर / नीला',day:'शनिवार',gem:'गोमेद (Hessonite)',career:'तकनीक, शोध, नवाचार, इंजीनियरिंग',dir:'नैऋत्य',element:'वायु',friends:'1, 2, 7, 8',tough:'5',mantra:'ॐ राहवे नमः',keywords:['नवाचार','साहस','विशिष्टता','दृढ़ता'],
                    hints:[{i:'⚙️',t:'नया बनाएं',d:'आपका मन अनोखी समस्याएं हल करने में खिलता है।'},{i:'🔵',t:'नीला-धूसर चुनें',d:'ठंडे रंग आपकी बेचैन ऊर्जा को स्थिर करते हैं।'},{i:'🧱',t:'व्यवस्था बनाएं',d:'दिनचर्या आपके विचारों को परिणाम में बदलती है।'},{i:'🌌',t:'अनोखे पर भरोसा',d:'जिस राह से लोग बचते हैं, वहीं आपकी जीत है।'}],
                    advice:'राहु आपको दुर्लभ, मौलिक दिमाग देता है। अपनी विशिष्टता अपनाएं — जो आपको अलग बनाता है वही आपकी ताकत है।'},
                5:{planet:'बुध',title:'चतुर वक्ता',desc:'आप तेज़, हाज़िरजवाब और अनुकूलनशील हैं। व्यापार और संवाद आपके मैदान हैं। आप बातों से कोई भी अवसर पा सकते हैं।',color:'हरा',day:'बुधवार',gem:'पन्ना (Emerald)',career:'व्यापार, मार्केटिंग, मीडिया, ट्रेडिंग, सेल्स',dir:'उत्तर',element:'पृथ्वी',friends:'5, 6, 9, 1',tough:'4',mantra:'ॐ बुधाय नमः',keywords:['संवाद','अनुकूलन','हाज़िरजवाबी','आकर्षण'],
                    hints:[{i:'💬',t:'अपनी आवाज़ उठाएं',d:'बोलें — शब्द आपकी सबसे बड़ी शक्ति हैं।'},{i:'💚',t:'हरा पहनें',d:'बुधवार को हरा रंग दिमाग व सौदे तेज़ करता है।'},{i:'📈',t:'समझदारी से व्यापार',d:'व्यापार की आपकी समझ सोना है — उस पर काम करें।'},{i:'🧠',t:'लचीले रहें',d:'जल्दी ढलें, आप हमेशा अपने पैरों पर खड़े रहेंगे।'}],
                    advice:'बुध आपको आकर्षण और तेज़ दिमाग देता है। अपने शब्दों से पुल बनाएं, दीवारें नहीं — हर जगह दरवाज़े खुलेंगे।'},
                6:{planet:'शुक्र',title:'सौंदर्य प्रेमी',desc:'आप आकर्षक, कलात्मक और प्रेमपूर्ण हैं। सुंदरता, सामंजस्य और रिश्ते आपके लिए सबसे अहम हैं। लोग आपकी गर्मजोशी की ओर खिंचते हैं।',color:'सफेद / आसमानी / गुलाबी',day:'शुक्रवार',gem:'हीरा / ओपल',career:'कला, डिज़ाइन, फैशन, आतिथ्य, मनोरंजन',dir:'आग्नेय',element:'जल',friends:'3, 6, 9',tough:'8',mantra:'ॐ शुक्राय नमः',keywords:['प्रेम','आकर्षण','रचनात्मकता','सामंजस्य'],
                    hints:[{i:'🌸',t:'सुंदरता से घिरें',d:'सुंदर वातावरण आपका मूड व भाग्य बढ़ाता है।'},{i:'🤍',t:'हल्के रंग पहनें',d:'गुलाबी व सफेद आपका आकर्षण बढ़ाते हैं।'},{i:'🎨',t:'कला रचें',d:'खुद को व्यक्त करें — रचनात्मकता आपका ईंधन है।'},{i:'💝',t:'खुलकर प्रेम करें',d:'आपके रिश्ते आपकी सबसे बड़ी पूंजी हैं।'}],
                    advice:'शुक्र आपको प्रेम और सौंदर्य देता है। दिल से चलें, स्वतंत्र रूप से रचें, और अपनी गर्मजोशी से सही लोगों को आकर्षित करें।'},
                7:{planet:'केतु',title:'आध्यात्मिक खोजी',desc:'आप अंतर्मुखी, रहस्यमय और उम्र से अधिक समझदार हैं। आप हर चीज़ में गहरा अर्थ ढूंढते हैं। एकांत आपको ऊर्जा देता है।',color:'सफेद / हल्का हरा',day:'सोमवार',gem:'लहसुनिया (Cat\'s Eye)',career:'शोध, अध्यात्म, मनोविज्ञान, लेखन, चिकित्सा',dir:'पश्चिम',element:'जल',friends:'2, 4, 7',tough:'1',mantra:'ॐ केतवे नमः',keywords:['अंतर्ज्ञान','ज्ञान','रहस्य','गहराई'],
                    hints:[{i:'🧘',t:'एकांत अपनाएं',d:'शांत समय आपकी गहरी समझ खोलता है।'},{i:'🤍',t:'सफेद पहनें',d:'सफेद व हल्के रंग आपके मन को शांत करते हैं।'},{i:'📿',t:'अध्यात्म करें',d:'ध्यान या प्रार्थना आपकी ऊर्जा संतुलित करती है।'},{i:'🌙',t:'अंतर्ज्ञान पर भरोसा',d:'आपकी अंदरूनी आवाज़ दिमाग से पहले जानती है।'}],
                    advice:'केतु आपको पुरानी आत्मा बनाता है। गहराई और एकांत की अपनी ज़रूरत का सम्मान करें — आपका ज्ञान दुनिया के लिए तोहफ़ा है।'},
                8:{planet:'शनि',title:'अनुशासित सफलता',desc:'आप मेहनती, धैर्यवान और बड़ी सफलता के लिए बने हैं — धीरे पर पक्की। शनि पहले परखता है, फिर भरपूर देता है। अनुशासन आपका जादू है।',color:'गहरा नीला / काला',day:'शनिवार',gem:'नीलम (Blue Sapphire)',career:'कानून, वित्त, रियल एस्टेट, नेतृत्व, इंजीनियरिंग',dir:'पश्चिम',element:'वायु',friends:'4, 8, 5',tough:'1, 2',mantra:'ॐ शनैश्चराय नमः',keywords:['अनुशासन','धैर्य','न्याय','सहनशक्ति'],
                    hints:[{i:'⏳',t:'धैर्य रखें',d:'आपका इनाम देर से पर बड़ा आता है।'},{i:'🔵',t:'गहरा नीला पहनें',d:'गहरे नीले रंग आपका फोकस व कर्म स्थिर करते हैं।'},{i:'⚖️',t:'ईमानदार रहें',d:'शनि सबसे ज़्यादा ईमानदारी को पुरस्कृत करता है।'},{i:'🛠',t:'चुपचाप मेहनत',d:'लगातार प्रयास आपके लिए भाग्य से बेहतर है।'}],
                    advice:'शनि सख्त पर न्यायप्रिय गुरु है। अनुशासित व नैतिक रहें — आपकी हर ईमानदार मेहनत दर्ज हो रही है और पुरस्कृत होगी।'},
                9:{planet:'मंगल',title:'निडर योद्धा',desc:'आप ऊर्जावान, बहादुर और जुनूनी हैं। आप सही के लिए लड़ते हैं और कभी हार नहीं मानते। आपका साहस सबको प्रेरित करता है।',color:'लाल / मूंगा',day:'मंगलवार',gem:'मूंगा (Red Coral)',career:'रक्षा, खेल, सर्जरी, इंजीनियरिंग, नेतृत्व',dir:'दक्षिण',element:'अग्नि',friends:'3, 6, 9',tough:'2',mantra:'ॐ मंगलाय नमः',keywords:['साहस','ऊर्जा','जुनून','वफ़ादारी'],
                    hints:[{i:'🔥',t:'ऊर्जा लगाएं',d:'रोज़ व्यायाम करके बेचैन ऊर्जा निकालें।'},{i:'🔴',t:'लाल पहनें',d:'मंगलवार को लाल रंग साहस व जोश बढ़ाता है।'},{i:'🧯',t:'गुस्से पर काबू',d:'प्रतिक्रिया से पहले रुकें — शक्ति को नियंत्रण चाहिए।'},{i:'🏆',t:'ऊंचा लक्ष्य',d:'आप जीतने के लिए बने हैं — बड़े लक्ष्य रखें।'}],
                    advice:'मंगल आपको आग और साहस से भरता है। उस ऊर्जा को धैर्य से दिशा दें, आप हर चुनौती जीत लेंगे।'}
            },
            luckyT:{color:'शुभ रंग',day:'शुभ दिन',num:'शुभ अंक',gem:'शुभ रत्न'},
            advLabels:{mulank:'मूलांक',bhagyank:'भाग्यांक',planet:'स्वामी ग्रह',friends:'मित्र अंक',tough:'चुनौती अंक',dir:'शुभ दिशा',element:'तत्व',mantra:'बीज मंत्र',career:'आदर्श करियर'},
            barLbl:['नेतृत्व','रचनात्मकता','भाग्य','रिश्ते'],
            wm:'mulank-calculator'
        }
    };

    // per-number base strengths [leadership, creativity, luck, relationships]
    var STR = {1:[95,70,75,65],2:[60,80,70,92],3:[80,88,90,82],4:[72,90,60,62],5:[78,85,80,80],6:[70,92,82,95],7:[65,85,72,68],8:[88,68,65,60],9:[92,78,80,75]};

    var state = {};

    function compute(dob){
        var parts = dob.split('-'); // YYYY-MM-DD
        var y = parts[0], m = parts[1], d = parts[2];
        var day = parseInt(d,10);
        var mulank = C.reduceDigit(day);
        var allDigits = (y+m+d).split('').reduce(function(s,ch){ return s + (parseInt(ch,10)||0); },0);
        var bhagyank = C.reduceDigit(allDigits);
        return {mulank:mulank, bhagyank:bhagyank, dob:dob};
    }

    function render(){
        var T = DATA[lang], n = state.mulank, b = state.bhagyank, info = T.n[n], binfo = T.n[b];
        var sd = C.seed(state.dob);
        $('mulank').textContent = n;
        $('level').textContent = '🪐 ' + info.planet + ' · ' + info.title;
        $('desc').textContent = info.desc;
        $('wm').textContent = T.wm + ' 🔮';

        // ring shows mulank proportion
        var circ = 2*Math.PI*86;
        setTimeout(function(){ $('ring').style.strokeDashoffset = circ-(circ*n/9); },80);

        // number chips
        var ng = $('numbers'); ng.innerHTML='';
        var chips = [
            {e:'🔢', ti:T.mulankLbl, v:String(n), note:info.planet},
            {e:'🌟', ti:T.bhagyankLbl, v:String(b), note:binfo.planet}
        ];
        chips.forEach(function(c,i){
            var d=document.createElement('div'); d.className='cts-x'; d.style.animationDelay=(i*0.08)+'s';
            d.innerHTML='<div class="cts-x-head"><span class="cts-x-emoji">'+c.e+'</span><span class="cts-x-title">'+C.escapeHtml(c.ti)+'</span></div><p class="cts-x-val">'+C.escapeHtml(c.v)+'</p><p class="cts-x-note">'+C.escapeHtml(c.note)+'</p>';
            ng.appendChild(d);
        });

        // bars
        var base = STR[n];
        function v(i){ var r=Math.abs(Math.sin(sd+i))*10-3; return Math.max(40,Math.min(99,Math.round(base[i]+r))); }
        var m=[v(0),v(1),v(2),v(3)];
        setTimeout(function(){
            for (var i=0;i<4;i++){ $('b'+(i+1)).style.width=m[i]+'%'; $('b'+(i+1)+'-v').textContent=m[i]+'%'; }
        },200);

        // lucky extras
        var L=T.luckyT, lg=$('lucky'); lg.innerHTML='';
        var lucky=[
            {e:'🎨', ti:L.color, v:info.color},
            {e:'📅', ti:L.day, v:info.day},
            {e:'🔟', ti:L.num, v:info.friends},
            {e:'💎', ti:L.gem, v:info.gem}
        ];
        lucky.forEach(function(c,i){
            var d=document.createElement('div'); d.className='cts-x'; d.style.animationDelay=(i*0.07)+'s';
            d.innerHTML='<div class="cts-x-head"><span class="cts-x-emoji">'+c.e+'</span><span class="cts-x-title">'+C.escapeHtml(c.ti)+'</span></div><p class="cts-x-val">'+C.escapeHtml(c.v)+'</p>';
            lg.appendChild(d);
        });

        // hints
        var hg=$('hints'); hg.innerHTML='';
        info.hints.forEach(function(h,i){
            var d=document.createElement('div'); d.className='cts-hint'; d.style.animationDelay=(i*0.1)+'s';
            d.innerHTML='<div class="cts-hint-icon">'+h.i+'</div><h4>'+C.escapeHtml(h.t)+'</h4><p>'+C.escapeHtml(h.d)+'</p>';
            hg.appendChild(d);
        });

        // advice + keywords
        $('advice').textContent = info.advice;
        var tags=$('tags'); tags.innerHTML='';
        info.keywords.forEach(function(k){ var s=document.createElement('span'); s.className='cts-tag'; s.textContent=k; tags.appendChild(s); });

        // advanced
        var al=T.advLabels;
        var advData=[
            [al.mulank, n+' · '+info.planet],
            [al.bhagyank, b+' · '+binfo.planet],
            [al.dir!==undefined?al.dir:'Direction', info.dir],
            [al.element, info.element],
            [al.friends, info.friends],
            [al.tough, info.tough],
            [al.mantra, info.mantra],
            [al.career, info.career]
        ];
        var ag=$('adv-grid'); ag.innerHTML='';
        advData.forEach(function(p){ var d=document.createElement('div'); d.className='cts-adv-item'; d.innerHTML='<div class="k">'+C.escapeHtml(p[0])+'</div><div class="v">'+C.escapeHtml(String(p[1]))+'</div>'; ag.appendChild(d); });
        if (root.classList.contains('cts-adv-active')) { $('adv-panel').classList.add('cts-show'); }

        // share
        var url=window.location.href;
        var shareTxt=(lang==='hi'?'🔮 मेरा मूलांक ':'🔮 My Mulank ')+n+' · '+(lang==='hi'?'भाग्यांक ':'Bhagyank ')+b+' ('+info.planet+')\n'+url;
        $('wa').href=C.shareWhatsApp(shareTxt);
        $('tw').href=C.shareTwitter('My Mulank '+n+' & Bhagyank '+b+' ('+info.planet+')', url);

        setTimeout(C.confetti,500);
        setTimeout(function(){ $('result').scrollIntoView({behavior:'smooth',block:'start'}); },100);
    }

    function go(){
        var dob=($('dob').value||'').trim(), err=$('error');
        if (!dob || !/^\d{4}-\d{2}-\d{2}$/.test(dob)){ err.textContent=lang==='hi'?'कृपया सही जन्मतिथि चुनें।':'Please select a valid date of birth.'; err.classList.add('cts-show'); return; }
        var dt=new Date(dob);
        if (isNaN(dt.getTime()) || dt > new Date()){ err.textContent=lang==='hi'?'जन्मतिथि भविष्य की नहीं हो सकती।':'Date of birth cannot be in the future.'; err.classList.add('cts-show'); return; }
        err.classList.remove('cts-show');
        var r=compute(dob); state.mulank=r.mulank; state.bhagyank=r.bhagyank; state.dob=dob;
        state.name=($('name').value||'').trim();
        $('input').style.display='none';
        var ld=$('loading'); ld.style.display='block'; ld.classList.add('cts-show');
        $('load-title').textContent = state.name ? state.name : '🔮';
        $('bar').style.width='0%';
        C.runLoading($('load-step'),$('bar'),DATA[lang].steps,function(){
            ld.classList.remove('cts-show'); ld.style.display='none';
            $('result').classList.add('cts-show'); render();
        });
    }

    function reset(){
        $('result').classList.remove('cts-show');
        $('loading').classList.remove('cts-show'); $('loading').style.display='none';
        $('input').style.display='block';
        $('dob').value=''; $('name').value='';
        $('mulank').textContent='0'; $('ring').style.strokeDashoffset=540.35;
        ['b1','b2','b3','b4'].forEach(function(id){ $(id).style.width='0%'; });
        $('adv-panel').classList.toggle('cts-show', root.classList.contains('cts-adv-active'));
        $('input').scrollIntoView({behavior:'smooth',block:'start'});
    }

    $('dob').addEventListener('input',function(){ $('error').classList.remove('cts-show'); });
    $('calc').addEventListener('click',go);
    $('try').addEventListener('click',reset);
    $('copy').addEventListener('click',function(){ C.copyLink(this, lang==='hi'?'✅ कॉपी हुआ!':'✅ Copied!'); });
    $('dl').addEventListener('click',function(){
        var T=DATA[lang], info=T.n[state.mulank];
        var ok=C.downloadCard({
            brand:'Mulank Calculator', title:(state.name||'')+(state.name?' · ':'')+info.planet,
            percent:Math.round(state.mulank/9*100), centerText:String(state.mulank), centerSub:T.mulankLbl,
            level:'🌟 '+T.bhagyankLbl+' '+state.bhagyank, desc:info.desc,
            footer:'mulank-calculator', file:'mulank-'+state.mulank
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
    C.liveCounter($('counter'),194830);
})();
</script>
        <?php
        return ob_get_clean();
    }

    add_shortcode( 'mulank_calculator', 'cts_mulank_render' );
}
