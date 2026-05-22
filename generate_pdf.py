#!/usr/bin/env python3
"""
AL NASAR PUBLIC MODEL SCHOOL — Premium PDF Syllabus Generator
Uses reportlab + arabic_reshaper + python-bidi for Urdu text.
"""

from reportlab.pdfgen import canvas
from reportlab.pdfbase import pdfmetrics
from reportlab.pdfbase.ttfonts import TTFont
from reportlab.lib.pagesizes import A4
from reportlab.lib.colors import (
    HexColor, white, black
)
from reportlab.platypus import (
    SimpleDocTemplate, Table, TableStyle, Paragraph,
    Spacer, HRFlowable, PageBreak, KeepTogether
)
from reportlab.platypus.flowables import Flowable
from reportlab.lib.styles import ParagraphStyle, getSampleStyleSheet
from reportlab.lib.units import cm, mm, inch
from reportlab.lib.enums import TA_CENTER, TA_LEFT, TA_RIGHT, TA_JUSTIFY
import arabic_reshaper
from bidi.algorithm import get_display
import os

# ══════════════════════════════════════════════════════════════════
# FONTS
# ══════════════════════════════════════════════════════════════════
FONT_DIR = '/usr/share/fonts/truetype/freefont/'
SERIF_DIR = '/usr/share/fonts/truetype/liberation/'

pdfmetrics.registerFont(TTFont('FreeSerif',         FONT_DIR + 'FreeSerif.ttf'))
pdfmetrics.registerFont(TTFont('FreeSerifBold',     FONT_DIR + 'FreeSerifBold.ttf'))
pdfmetrics.registerFont(TTFont('FreeSerifItalic',   FONT_DIR + 'FreeSerifItalic.ttf'))
pdfmetrics.registerFont(TTFont('LiberSerif',        SERIF_DIR + 'LiberationSerif-Regular.ttf'))
pdfmetrics.registerFont(TTFont('LiberSerifBold',    SERIF_DIR + 'LiberationSerif-Bold.ttf'))
pdfmetrics.registerFont(TTFont('LiberSerifItalic',  SERIF_DIR + 'LiberationSerif-Italic.ttf'))

# ══════════════════════════════════════════════════════════════════
# COLOURS
# ══════════════════════════════════════════════════════════════════
C_NAVY     = HexColor('#1A2C56')
C_NAVY2    = HexColor('#243A6B')
C_GOLD     = HexColor('#B8862A')
C_LGOLD    = HexColor('#FDF3E0')
C_ALTBLUE  = HexColor('#EDF4FF')
C_WHITE    = HexColor('#FFFFFF')
C_DARK     = HexColor('#222222')
C_MID      = HexColor('#555555')
C_WARN     = HexColor('#B03020')
C_GREEN    = HexColor('#1A5C38')

# ══════════════════════════════════════════════════════════════════
# URDU TEXT HELPER
# ══════════════════════════════════════════════════════════════════
def urdu(text):
    """Reshape and apply bidi algorithm for Urdu/Arabic display."""
    reshaped = arabic_reshaper.reshape(text)
    return get_display(reshaped)

# ══════════════════════════════════════════════════════════════════
# PAGE TEMPLATE WITH BORDER + FOOTER
# ══════════════════════════════════════════════════════════════════
PAGE_W, PAGE_H = A4
MARGIN_L = 1.5 * cm
MARGIN_R = 1.5 * cm
MARGIN_T = 1.3 * cm
MARGIN_B = 1.6 * cm
USABLE_W = PAGE_W - MARGIN_L - MARGIN_R

def draw_page_border(c, doc):
    """Gold border around each page."""
    c.saveState()
    c.setStrokeColor(C_GOLD)
    c.setLineWidth(1.5)
    border_pad = 6
    c.rect(border_pad, border_pad,
           PAGE_W - 2 * border_pad, PAGE_H - 2 * border_pad,
           stroke=1, fill=0)
    # Inner thin line
    c.setLineWidth(0.4)
    inner_pad = 9
    c.rect(inner_pad, inner_pad,
           PAGE_W - 2 * inner_pad, PAGE_H - 2 * inner_pad,
           stroke=1, fill=0)
    c.restoreState()


def draw_footer(c, doc):
    """Footer: school info left | page number centre | created by right."""
    c.saveState()
    y = 0.55 * cm

    # Separator line
    c.setStrokeColor(C_GOLD)
    c.setLineWidth(0.6)
    c.line(MARGIN_L, y + 0.45 * cm, PAGE_W - MARGIN_R, y + 0.45 * cm)

    # Left: school name + address
    c.setFont('LiberSerifBold', 6.5)
    c.setFillColor(C_NAVY)
    c.drawString(MARGIN_L, y + 0.2 * cm, 'AL NASAR PUBLIC MODEL SCHOOL')
    c.setFont('LiberSerif', 6)
    c.setFillColor(C_MID)
    c.drawString(MARGIN_L, y - 0.1 * cm, '362 J/B Korian   ·   \U0001f4de 03007201254')

    # Centre: page number
    c.setFont('LiberSerif', 7)
    c.setFillColor(C_GOLD)
    page_str = f'— {doc.page} —'
    c.drawCentredString(PAGE_W / 2, y + 0.05 * cm, page_str)

    # Right: created by (Urdu + English)
    c.setFont('FreeSerifItalic', 6.5)
    c.setFillColor(C_GOLD)
    created_txt = '✨  Created & Prepared By  Muhammad Rehan 08  ✨'
    c.drawRightString(PAGE_W - MARGIN_R, y + 0.05 * cm, created_txt)

    c.restoreState()


def on_page(c, doc):
    draw_page_border(c, doc)
    draw_footer(c, doc)


# ══════════════════════════════════════════════════════════════════
# CUSTOM FLOWABLES
# ══════════════════════════════════════════════════════════════════
class GoldRule(Flowable):
    """A thin gold horizontal rule."""
    def __init__(self, width=None, thickness=0.6, color=C_GOLD):
        Flowable.__init__(self)
        self.width   = width
        self.thick   = thickness
        self.color   = color
        self.height  = thickness + 2

    def draw(self):
        self.canv.setStrokeColor(self.color)
        self.canv.setLineWidth(self.thick)
        w = self.width or USABLE_W
        self.canv.line(0, self.thick / 2, w, self.thick / 2)

    def wrap(self, *args):
        return (self.width or USABLE_W, self.height)


# ══════════════════════════════════════════════════════════════════
# PARAGRAPH STYLES
# ══════════════════════════════════════════════════════════════════
def S(name, font='LiberSerif', size=10, color=C_DARK,
      align=TA_CENTER, bold=False, italic=False,
      leading=None, space_before=0, space_after=0):
    fn = font
    if bold and italic:   fn = font.replace('Serif', 'Serif') + 'BoldItalic' if 'Liber' in font else 'FreeSerifBoldItalic'
    elif bold:            fn = 'LiberSerifBold' if 'Liber' in font else 'FreeSerifBold'
    elif italic:          fn = 'LiberSerifItalic' if 'Liber' in font else 'FreeSerifItalic'
    return ParagraphStyle(
        name,
        fontName=fn,
        fontSize=size,
        textColor=color,
        alignment=align,
        leading=leading or (size * 1.3),
        spaceBefore=space_before,
        spaceAfter=space_after,
    )

# ══════════════════════════════════════════════════════════════════
# BUILD STORY
# ══════════════════════════════════════════════════════════════════
def build_story():
    story = []

    # ── SCHOOL NAME HEADER ────────────────────────────────────────
    hdr_data = [[
        [
            Paragraph('<b>&#9733;  AL NASAR PUBLIC MODEL SCHOOL  &#9733;</b>',
                      S('hdr_name', size=17, color=C_WHITE, align=TA_CENTER, bold=True)),
            Spacer(1, 2),
            GoldRule(USABLE_W - 2 * cm, 0.5, C_GOLD),
            Spacer(1, 3),
            Paragraph('<b>CLASS 6 &nbsp;&nbsp; &#9670; &nbsp;&nbsp; '
                      'FIRST TERM SYLLABUS + Summer Vacations &#127774; &nbsp;&nbsp; &#9670; &nbsp;&nbsp; '
                      'SESSION 2026 – 2027</b>',
                      S('hdr_sub', size=10, color=C_GOLD, align=TA_CENTER, bold=True)),
        ]
    ]]
    hdr_tbl = Table(hdr_data, colWidths=[USABLE_W])
    hdr_tbl.setStyle(TableStyle([
        ('BACKGROUND',   (0, 0), (-1, -1), C_NAVY),
        ('BOX',          (0, 0), (-1, -1), 1.4, C_GOLD),
        ('TOPPADDING',   (0, 0), (-1, -1), 10),
        ('BOTTOMPADDING',(0, 0), (-1, -1), 10),
        ('LEFTPADDING',  (0, 0), (-1, -1), 14),
        ('RIGHTPADDING', (0, 0), (-1, -1), 14),
    ]))
    story.append(hdr_tbl)
    story.append(Spacer(1, 4))

    # ── INFO CARDS ─────────────────────────────────────────────────
    cw = USABLE_W / 3

    def info_card(label, value):
        return [
            Paragraph(f'<b>{label}</b>', S('il', size=8, color=C_GOLD, align=TA_CENTER, bold=True)),
            Spacer(1, 2),
            Paragraph(f'<b>{value}</b>', S('iv', size=10, color=C_WHITE, align=TA_CENTER, bold=True)),
        ]

    info_data = [[
        info_card('\U0001f4c5  SESSION', '2026 – 2027'),
        info_card('\U0001f4d8  TERM', 'First Term'),
        info_card('✍  PREPARED BY', 'Muhammad Rehan 08'),
    ]]
    info_tbl = Table(info_data, colWidths=[cw, cw, cw])
    info_tbl.setStyle(TableStyle([
        ('BACKGROUND',   (0, 0), (0, 0), C_NAVY),
        ('BACKGROUND',   (1, 0), (1, 0), C_NAVY2),
        ('BACKGROUND',   (2, 0), (2, 0), C_NAVY),
        ('BOX',          (0, 0), (0, 0), 0.8, C_GOLD),
        ('BOX',          (1, 0), (1, 0), 0.8, C_GOLD),
        ('BOX',          (2, 0), (2, 0), 0.8, C_GOLD),
        ('TOPPADDING',   (0, 0), (-1, -1), 7),
        ('BOTTOMPADDING',(0, 0), (-1, -1), 7),
        ('LEFTPADDING',  (0, 0), (-1, -1), 8),
        ('RIGHTPADDING', (0, 0), (-1, -1), 8),
        ('VALIGN',       (0, 0), (-1, -1), 'MIDDLE'),
    ]))
    story.append(info_tbl)
    story.append(Spacer(1, 5))

    # ── IMPORTANT NOTES ────────────────────────────────────────────
    warn_data = [[
        Paragraph(
            '<b>⚠   IMPORTANT :  \U0001f334  Summer Vacation: 15 June – 1 August 2026'
            '&nbsp;&nbsp; | &nbsp;&nbsp; \U0001f4c4  '
            'First Term papers will be prepared STRICTLY from this syllabus</b>',
            S('warn', size=8.5, color=C_WHITE, align=TA_CENTER, bold=True))
    ]]
    warn_tbl = Table(warn_data, colWidths=[USABLE_W])
    warn_tbl.setStyle(TableStyle([
        ('BACKGROUND',   (0, 0), (-1, -1), C_WARN),
        ('TOPPADDING',   (0, 0), (-1, -1), 6),
        ('BOTTOMPADDING',(0, 0), (-1, -1), 6),
        ('LEFTPADDING',  (0, 0), (-1, -1), 10),
        ('RIGHTPADDING', (0, 0), (-1, -1), 10),
    ]))
    story.append(warn_tbl)
    story.append(Spacer(1, 5))

    # ── INTRODUCTION + OBJECTIVES ──────────────────────────────────
    intro_lines = [
        'پیارے طلبائے کرام! اَلنَّصر پبلک ماڈل اسکول میں آپ کا دلی خیر مقدم ہے۔',
        'یہ مکمل نصابِ تعلیم آپ کی پہلی سہ ماہی کا مستند رہنما دستاویز ہے۔',
        'ہر مضمون کو توجہ، لگن اور دلجمعی سے پڑھیں اور مسلسل مشق کریں۔',
        'محنت، ایمانداری اور ثابت قدمی سے کامیابی یقینی ہے۔',
    ]
    obj_lines = [
        '۱۔  ہر مضمون میں علمی بنیاد کو مضبوط اور پائیدار بنانا۔',
        '۲۔  پڑھنے، لکھنے اور تجزیہ کرنے کی صلاحیت نکھارنا۔',
        '۳۔  نظم و ضبط اور مطالعے کی مستقل عادت راسخ کرنا۔',
        '۴۔  پہلی سہ ماہی کے امتحانات میں شاندار کارکردگی۔',
    ]

    def urdu_lines_cell(title, lines, bg):
        items = [
            Paragraph(urdu(title),
                      S('ut', 'FreeSerifBold', 10.5, C_NAVY, TA_RIGHT, bold=True)),
            Spacer(1, 3),
        ]
        for line in lines:
            items.append(
                Paragraph(urdu(line),
                          S('ul', 'FreeSerif', 8.5, C_DARK, TA_RIGHT, leading=13))
            )
        return items

    half = USABLE_W / 2 - 1

    io_data = [[
        urdu_lines_cell('تعارف', intro_lines, C_LGOLD),
        urdu_lines_cell('مقاصد', obj_lines, C_ALTBLUE),
    ]]
    io_tbl = Table(io_data, colWidths=[half, half], hAlign='LEFT')
    io_tbl.setStyle(TableStyle([
        ('BACKGROUND',   (0, 0), (0, 0), C_LGOLD),
        ('BACKGROUND',   (1, 0), (1, 0), C_ALTBLUE),
        ('BOX',          (0, 0), (0, 0), 0.7, C_GOLD),
        ('BOX',          (1, 0), (1, 0), 0.7, C_GOLD),
        ('TOPPADDING',   (0, 0), (-1, -1), 7),
        ('BOTTOMPADDING',(0, 0), (-1, -1), 7),
        ('LEFTPADDING',  (0, 0), (-1, -1), 10),
        ('RIGHTPADDING', (0, 0), (-1, -1), 10),
        ('VALIGN',       (0, 0), (-1, -1), 'TOP'),
        ('LINEAFTER',    (0, 0), (0, 0), 1.5, C_GOLD),
    ]))
    story.append(io_tbl)
    story.append(Spacer(1, 6))

    # ── SYLLABUS HEADING ───────────────────────────────────────────
    story.append(
        Paragraph('<b>✦ &nbsp; FIRST TERM — COURSE OUTLINE &nbsp; ✦</b>',
                  S('sh', size=10, color=C_NAVY, align=TA_CENTER, bold=True))
    )
    story.append(Spacer(1, 3))

    # ── SYLLABUS TABLE ─────────────────────────────────────────────
    subjects = [
        ('اُردو', True, [
            'اسباق: سبق ۱ تا ۷ بمعہ تمام مشقیں',
            'خطوط: چچا کے نام (گھڑی کا تحفہ) • چھوٹے بھائی کے نام محنت کی تلقین',
            'مضامین: ہمارا وطن • ہمارے پیارے رسول حضرت محمد ﷺ',
            'کہانیاں: جیسا کرو گے ویسا بھرو گے • خوشامد بُری بلا ہے',
            'درخواستیں: دوبارہ داخلہ • فیس معافی',
            'گرامر: اسم کی اقسام • اسم معرفہ کی اقسام',
        ]),
        ('English', False, [
            '▸ Course: Chapter 1 – 4 with all exercises',
            '▸ Grammar: Homophones • Compound Words • Parts of Speech',
            '▸ Applications: Sick Leave • Urgent Work • Marriage Party',
            '▸ Letters: Birthday Thanks • Summer Vacation • Lending a Camera',
            '▸ Stories: Greed is a Curse • Grapes are Sour • Nature Cannot Change',
            '▸ Essays: Quaid-e-Azam • Morning Walk • Sportsmanship',
        ]),
        ('Mathematics', False, [
            '▸ Exercise 1.1 to 1.6 — Complete',
            '▸ All solved examples, exercises and chapter revision included.',
        ]),
        ('Science', False, [
            '▸ Chapter 1 to 4 — Complete',
            '▸ Full exercises, definitions, diagrams and end-of-chapter questions.',
        ]),
        ('کمپیوٹر', True, [
            'سبق ۱ تا ۳ بمعہ مشق',
            'تمام سوالات، تعریفات اور عملی مشقیں شامل ہیں۔',
        ]),
        ('اسلامیات', True, [
            'سبق ۱ تا ۹ بمعہ مشق',
            'تمام آیات، احادیث اور سوالات کی مکمل تیاری۔',
        ]),
        ('تاریخ', True, [
            'سبق ۱ تا ۴ بمعہ مشق',
            'تمام اہم واقعات، شخصیات اور سوالات کی تیاری۔',
        ]),
    ]

    SUBJ_W   = 2.8 * cm
    CONT_W   = USABLE_W - SUBJ_W

    # Header
    syl_rows = [[
        Paragraph('<b>SUBJECT</b>',      S('sh0', size=9, color=C_GOLD, align=TA_CENTER, bold=True)),
        Paragraph('<b>COURSE CONTENT</b>', S('sh1', size=9, color=C_GOLD, align=TA_CENTER, bold=True)),
    ]]

    ts_cmds = [
        # Header
        ('BACKGROUND',   (0, 0), (-1, 0), C_NAVY),
        ('BOX',          (0, 0), (-1, 0), 0.8, C_GOLD),
        ('TOPPADDING',   (0, 0), (-1, 0), 6),
        ('BOTTOMPADDING',(0, 0), (-1, 0), 6),
        ('LINEAFTER',    (0, 0), (0, 0), 0.8, C_GOLD),
    ]

    for idx, (subj, is_urdu, lines) in enumerate(subjects):
        row_n = idx + 1
        bg = C_LGOLD if idx % 2 == 0 else C_ALTBLUE

        # Subject cell
        if is_urdu:
            subj_cell = Paragraph(urdu(subj),
                                  S(f'sn{idx}', 'FreeSerifBold', 9.5, C_NAVY, TA_CENTER, bold=True))
        else:
            subj_cell = Paragraph(f'<b>{subj}</b>',
                                  S(f'sn{idx}', size=9.5, color=C_NAVY, align=TA_CENTER, bold=True))

        # Content cell
        content_items = []
        for i, line in enumerate(lines):
            if is_urdu:
                content_items.append(
                    Paragraph(urdu(line),
                               S(f'cl{idx}{i}', 'FreeSerif', 8.5, C_DARK, TA_RIGHT, leading=12))
                )
            else:
                content_items.append(
                    Paragraph(line, S(f'cl{idx}{i}', size=8.5, color=C_DARK, align=TA_LEFT, leading=12))
                )
            if i < len(lines) - 1:
                content_items.append(Spacer(1, 1))

        syl_rows.append([subj_cell, content_items])

        ts_cmds += [
            ('BACKGROUND',    (0, row_n), (-1, row_n), bg),
            ('BOX',           (0, row_n), (-1, row_n), 0.5, C_GOLD),
            ('LINEAFTER',     (0, row_n), (0, row_n), 0.5, C_GOLD),
            ('TOPPADDING',    (0, row_n), (-1, row_n), 5),
            ('BOTTOMPADDING', (0, row_n), (-1, row_n), 5),
            ('VALIGN',        (0, row_n), (0, row_n), 'MIDDLE'),
            ('VALIGN',        (1, row_n), (1, row_n), 'TOP'),
        ]

    ts_cmds += [
        ('LEFTPADDING',  (0, 0), (-1, -1), 8),
        ('RIGHTPADDING', (0, 0), (-1, -1), 8),
    ]

    syl_tbl = Table(syl_rows, colWidths=[SUBJ_W, CONT_W])
    syl_tbl.setStyle(TableStyle(ts_cmds))
    story.append(syl_tbl)
    story.append(Spacer(1, 6))

    # ── PARENTS GUIDELINES ─────────────────────────────────────────
    pg_title = Paragraph(
        urdu('❖   والدین کے لیے ضروری ہدایات   ❖'),
        S('pgt', 'FreeSerifBold', 10.5, C_GOLD, TA_CENTER, bold=True)
    )

    pg_lines_raw = [
        '۱۔  والدین اس بات کو یقینی بنائیں کہ بچہ روزانہ کا سبق اور مشق گھر پر باقاعدگی سے مکمل کرے۔',
        '۲۔  نوٹ بکس کی روزانہ جانچ کریں اور کلاس ٹیچر کے ساتھ مسلسل رابطے میں رہیں۔',
        '۳۔  اگر بچے کا کام مکمل نہ ہو تو اُنہیں امتحان میں بیٹھنے کی اجازت نہیں دی جائے گی۔',
        '۴۔  بچوں کو وقت پر اسکول بھیجیں — غیر حاضری اور تاخیر سے سختی سے گریز کریں۔',
        '۵۔  یونیفارم، صفائی، کتب اور نظم و ضبط کا ہر وقت خاص خیال رکھیں۔',
        '۶۔  گرمیوں کی چھٹیاں ۱۵ جون تا یکم اگست ہوں گی؛ تمام بچے ہوم ورک مکمل کر کے واپس آئیں۔',
    ]

    pg_content = [pg_title, Spacer(1, 4)]
    for line in pg_lines_raw:
        pg_content.append(
            Paragraph(urdu(line),
                      S('pgl', 'FreeSerif', 8.5, C_WHITE, TA_RIGHT, leading=13))
        )
        pg_content.append(Spacer(1, 1))

    pg_data = [[pg_content]]
    pg_tbl = Table(pg_data, colWidths=[USABLE_W])
    pg_tbl.setStyle(TableStyle([
        ('BACKGROUND',   (0, 0), (-1, -1), C_NAVY),
        ('BOX',          (0, 0), (-1, -1), 1.0, C_GOLD),
        ('TOPPADDING',   (0, 0), (-1, -1), 8),
        ('BOTTOMPADDING',(0, 0), (-1, -1), 8),
        ('LEFTPADDING',  (0, 0), (-1, -1), 12),
        ('RIGHTPADDING', (0, 0), (-1, -1), 12),
    ]))
    story.append(pg_tbl)
    story.append(Spacer(1, 6))

    # ── STUDY TIPS ─────────────────────────────────────────────────
    tips = [
        ('\U0001f4dd  STUDY DAILY',   'Revise every lesson & complete exercises the same day.'),
        ('\U0001f4da  WRITE NEATLY',  'Maintain clean, well-organised notebooks for every subject.'),
        ('⏰  BE ON TIME',         'Punctuality and full attendance build strong learning habits.'),
    ]

    tips_data = [[
        [
            Paragraph(f'<b>{t}</b>',
                      S(f'tt{i}', size=8.5, color=C_NAVY, align=TA_CENTER, bold=True)),
            Spacer(1, 2),
            Paragraph(d, S(f'td{i}', size=7.5, color=C_DARK, align=TA_CENTER, leading=11)),
        ]
        for i, (t, d) in enumerate(tips)
    ]]

    tip_w = USABLE_W / 3
    tips_tbl = Table(tips_data, colWidths=[tip_w, tip_w, tip_w])
    tips_tbl.setStyle(TableStyle([
        ('BACKGROUND',   (0, 0), (0, 0), C_LGOLD),
        ('BACKGROUND',   (1, 0), (1, 0), C_ALTBLUE),
        ('BACKGROUND',   (2, 0), (2, 0), C_LGOLD),
        ('BOX',          (0, 0), (0, 0), 0.6, C_GOLD),
        ('BOX',          (1, 0), (1, 0), 0.6, C_GOLD),
        ('BOX',          (2, 0), (2, 0), 0.6, C_GOLD),
        ('TOPPADDING',   (0, 0), (-1, -1), 7),
        ('BOTTOMPADDING',(0, 0), (-1, -1), 7),
        ('LEFTPADDING',  (0, 0), (-1, -1), 8),
        ('RIGHTPADDING', (0, 0), (-1, -1), 8),
    ]))
    story.append(tips_tbl)
    story.append(Spacer(1, 5))

    # ── GOOD LUCK ──────────────────────────────────────────────────
    story.append(
        Paragraph('<b>\U0001f60a &nbsp; GOOD LUCK, DEAR STUDENTS! &nbsp; \U0001f60a</b>',
                  S('gl', size=10, color=C_NAVY, align=TA_CENTER, bold=True))
    )
    story.append(Spacer(1, 2))
    story.append(
        Paragraph('<i>“ Work hard, stay curious, and believe in yourself! ”</i>',
                  S('qt', size=8.5, color=C_GOLD, align=TA_CENTER, italic=True))
    )
    story.append(Spacer(1, 8))

    # ── SIGNATURE SECTION ──────────────────────────────────────────
    story.append(GoldRule(USABLE_W, 0.5, C_NAVY))
    story.append(Spacer(1, 3))
    story.append(
        Paragraph(
            '<b>▬▬▬▬▬▬ &nbsp;&nbsp; '
            'ACKNOWLEDGEMENT &nbsp; / &nbsp; '
            + urdu('تصدیق') +
            ' &nbsp;&nbsp; ▬▬▬▬▬▬</b>',
            S('ack', size=8.5, color=C_NAVY, align=TA_CENTER, bold=True)
        )
    )
    story.append(Spacer(1, 4))

    sig_titles_eng = ["Parents' Signature", "Teacher's Signature", "Principal's Signature"]
    sig_titles_urd = ['والدین کے دستخط', 'استاد کے دستخط', 'پرنسپل کے دستخط']

    sig_w = USABLE_W / 3

    def sig_col(eng_title, urd_title):
        return [
            Paragraph(urdu(urd_title),
                      S('st_u', 'FreeSerifBold', 9, C_NAVY, TA_CENTER, bold=True)),
            Paragraph(f'<b>{eng_title}</b>',
                      S('st_e', size=7.5, color=C_NAVY, align=TA_CENTER, bold=True)),
            Spacer(1, 18),
            Paragraph('_' * 26,
                      S('sln', size=11, color=C_GOLD, align=TA_CENTER)),
            Spacer(1, 4),
            Paragraph('Name: ______________________________',
                      S('snm', size=7.5, color=C_DARK, align=TA_LEFT)),
            Spacer(1, 2),
            Paragraph('Date: _______________________________',
                      S('sdt', size=7.5, color=C_DARK, align=TA_LEFT)),
        ]

    sig_data = [[
        sig_col(sig_titles_eng[0], sig_titles_urd[0]),
        sig_col(sig_titles_eng[1], sig_titles_urd[1]),
        sig_col(sig_titles_eng[2], sig_titles_urd[2]),
    ]]

    sig_tbl = Table(sig_data, colWidths=[sig_w, sig_w, sig_w])
    sig_tbl.setStyle(TableStyle([
        ('BACKGROUND',   (0, 0), (-1, -1), C_LGOLD),
        ('BOX',          (0, 0), (0, 0), 0.6, C_GOLD),
        ('BOX',          (1, 0), (1, 0), 0.6, C_GOLD),
        ('BOX',          (2, 0), (2, 0), 0.6, C_GOLD),
        ('LINEBEFORE',   (1, 0), (1, 0), 0.5, C_GOLD),
        ('LINEBEFORE',   (2, 0), (2, 0), 0.5, C_GOLD),
        ('TOPPADDING',   (0, 0), (-1, -1), 8),
        ('BOTTOMPADDING',(0, 0), (-1, -1), 10),
        ('LEFTPADDING',  (0, 0), (-1, -1), 10),
        ('RIGHTPADDING', (0, 0), (-1, -1), 10),
        ('VALIGN',       (0, 0), (-1, -1), 'TOP'),
    ]))
    story.append(sig_tbl)

    return story


# ══════════════════════════════════════════════════════════════════
# MAIN
# ══════════════════════════════════════════════════════════════════
if __name__ == '__main__':
    out_pdf = '/home/user/my--repo/AL_NASAR_Premium_Syllabus_2026.pdf'

    doc = SimpleDocTemplate(
        out_pdf,
        pagesize=A4,
        topMargin=MARGIN_T,
        bottomMargin=MARGIN_B,
        leftMargin=MARGIN_L,
        rightMargin=MARGIN_R,
        title='AL NASAR Premium Syllabus 2026',
        author='Muhammad Rehan 08',
    )

    story = build_story()
    doc.build(story, onFirstPage=on_page, onLaterPages=on_page)
    print(f'PDF saved: {out_pdf}')
