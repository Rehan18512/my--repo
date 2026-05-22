#!/usr/bin/env python3
"""
AL NASAR PUBLIC MODEL SCHOOL — Premium Syllabus Generator
Produces a 2-page professional DOCX + PDF syllabus.
"""

from docx import Document
from docx.shared import Pt, Cm, RGBColor, Twips
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_ALIGN_VERTICAL, WD_TABLE_ALIGNMENT
from docx.oxml.ns import qn
from docx.oxml import OxmlElement

# ══════════════════════════════════════════════════════════════════
# COLOUR PALETTE
# ══════════════════════════════════════════════════════════════════
NAVY      = '1A2C56'
NAVY2     = '243A6B'
GOLD      = 'B8862A'
LGOLD     = 'FDF3E0'
ALTBLUE   = 'EDF4FF'
WHITE     = 'FFFFFF'
DARKGRAY  = '333333'
MIDGRAY   = '666666'
WARN_RED  = 'B03020'

NAVY_RGB  = RGBColor(0x1A, 0x2C, 0x56)
GOLD_RGB  = RGBColor(0xB8, 0x86, 0x2A)
WHITE_RGB = RGBColor(0xFF, 0xFF, 0xFF)
RED_RGB   = RGBColor(0xB0, 0x30, 0x20)
DARK_RGB  = RGBColor(0x33, 0x33, 0x33)
MID_RGB   = RGBColor(0x66, 0x66, 0x66)

# ══════════════════════════════════════════════════════════════════
# XML HELPERS
# ══════════════════════════════════════════════════════════════════

def set_bg(cell, fill_hex):
    tcPr = cell._tc.get_or_add_tcPr()
    for o in tcPr.findall(qn('w:shd')):
        tcPr.remove(o)
    s = OxmlElement('w:shd')
    s.set(qn('w:val'), 'clear')
    s.set(qn('w:color'), 'auto')
    s.set(qn('w:fill'), fill_hex)
    tcPr.append(s)


def set_borders(cell, color=GOLD, sz=6, sides=None):
    if sides is None:
        sides = ['top', 'left', 'bottom', 'right']
    tcPr = cell._tc.get_or_add_tcPr()
    for o in tcPr.findall(qn('w:tcBorders')):
        tcPr.remove(o)
    b = OxmlElement('w:tcBorders')
    for side in sides:
        e = OxmlElement(f'w:{side}')
        e.set(qn('w:val'), 'single')
        e.set(qn('w:sz'), str(sz))
        e.set(qn('w:space'), '0')
        e.set(qn('w:color'), color)
        b.append(e)
    tcPr.append(b)


def no_borders(cell):
    tcPr = cell._tc.get_or_add_tcPr()
    for o in tcPr.findall(qn('w:tcBorders')):
        tcPr.remove(o)
    b = OxmlElement('w:tcBorders')
    for side in ['top', 'left', 'bottom', 'right', 'insideH', 'insideV']:
        e = OxmlElement(f'w:{side}')
        e.set(qn('w:val'), 'nil')
        e.set(qn('w:sz'), '0')
        e.set(qn('w:space'), '0')
        e.set(qn('w:color'), 'auto')
        b.append(e)
    tcPr.append(b)


def set_cell_margins(cell, top=40, bottom=40, left=80, right=80):
    tcPr = cell._tc.get_or_add_tcPr()
    for o in tcPr.findall(qn('w:tcMar')):
        tcPr.remove(o)
    m = OxmlElement('w:tcMar')
    for side, val in [('top', top), ('bottom', bottom), ('left', left), ('right', right)]:
        e = OxmlElement(f'w:{side}')
        e.set(qn('w:w'), str(val))
        e.set(qn('w:type'), 'dxa')
        m.append(e)
    tcPr.append(m)


def set_row_height(row, height_pt, rule='exact'):
    tr = row._tr
    trPr = tr.get_or_add_trPr()
    for o in trPr.findall(qn('w:trHeight')):
        trPr.remove(o)
    trH = OxmlElement('w:trHeight')
    trH.set(qn('w:val'), str(int(height_pt * 20)))
    trH.set(qn('w:hRule'), rule)
    trPr.append(trH)


def set_spacing(para, before=0, after=0, line=None):
    pPr = para._p.get_or_add_pPr()
    for o in pPr.findall(qn('w:spacing')):
        pPr.remove(o)
    s = OxmlElement('w:spacing')
    s.set(qn('w:before'), str(int(before * 20)))
    s.set(qn('w:after'), str(int(after * 20)))
    if line:
        s.set(qn('w:line'), str(int(line * 20)))
        s.set(qn('w:lineRule'), 'exact')
    pPr.append(s)


def apply_urdu_font(run, size=9.5, bold=False, color=None, font='Jameel Noori Nastaleeq'):
    run.font.size = Pt(size)
    run.bold = bold
    if color:
        run.font.color.rgb = color
    rPr = run._r.get_or_add_rPr()
    for o in rPr.findall(qn('w:rFonts')):
        rPr.remove(o)
    rf = OxmlElement('w:rFonts')
    rf.set(qn('w:ascii'), 'Times New Roman')
    rf.set(qn('w:hAnsi'), 'Times New Roman')
    rf.set(qn('w:cs'), font)
    rPr.insert(0, rf)
    for o in rPr.findall(qn('w:szCs')):
        rPr.remove(o)
    csz = OxmlElement('w:szCs')
    csz.set(qn('w:val'), str(int(size * 2)))
    rPr.append(csz)
    rPr.append(OxmlElement('w:rtl'))


def u_para(container, text, size=9.5, bold=False, color=None,
           sp_b=0, sp_a=0, font='Jameel Noori Nastaleeq'):
    """Add an Urdu RTL paragraph."""
    p = container.add_paragraph()
    pPr = p._p.get_or_add_pPr()
    pPr.append(OxmlElement('w:bidi'))
    jc = OxmlElement('w:jc')
    jc.set(qn('w:val'), 'right')
    pPr.append(jc)
    set_spacing(p, sp_b, sp_a)
    run = p.add_run(text)
    apply_urdu_font(run, size, bold, color, font)
    return p


def e_para(container, text, size=10, bold=False, color=None,
           align=WD_ALIGN_PARAGRAPH.CENTER, sp_b=0, sp_a=0,
           italic=False, font='Georgia'):
    """Add an English LTR paragraph."""
    p = container.add_paragraph()
    p.alignment = align
    set_spacing(p, sp_b, sp_a)
    run = p.add_run(text)
    run.bold = bold
    run.italic = italic
    run.font.size = Pt(size)
    run.font.name = font
    if color:
        run.font.color.rgb = color
    return p


def add_page_border(section, color=GOLD, sz=18, space=18):
    sectPr = section._sectPr
    for o in sectPr.findall(qn('w:pgBorders')):
        sectPr.remove(o)
    pgB = OxmlElement('w:pgBorders')
    pgB.set(qn('w:offsetFrom'), 'page')
    for side in ['top', 'left', 'bottom', 'right']:
        e = OxmlElement(f'w:{side}')
        e.set(qn('w:val'), 'single')
        e.set(qn('w:sz'), str(sz))
        e.set(qn('w:space'), str(space))
        e.set(qn('w:color'), color)
        pgB.append(e)
    sectPr.insert(0, pgB)


def set_table_no_space(table):
    for row in table.rows:
        for cell in row.cells:
            for para in cell.paragraphs:
                set_spacing(para, 0, 0)


def merge_row_cells(table, row_idx, start, end):
    row = table.rows[row_idx]
    merged = row.cells[start].merge(row.cells[end])
    return merged


# ══════════════════════════════════════════════════════════════════
# BUILD DOCUMENT
# ══════════════════════════════════════════════════════════════════

doc = Document()

# Remove Normal style default spacing
ns = doc.styles['Normal']
ns.paragraph_format.space_before = Pt(0)
ns.paragraph_format.space_after  = Pt(0)

# ── Page Setup ──────────────────────────────────────────────────
sec = doc.sections[0]
sec.page_height     = Cm(29.7)
sec.page_width      = Cm(21.0)
sec.top_margin      = Cm(1.3)
sec.bottom_margin   = Cm(1.6)
sec.left_margin     = Cm(1.5)
sec.right_margin    = Cm(1.5)
sec.footer_distance = Cm(0.65)

add_page_border(sec, GOLD, 16, 18)

# ── FOOTER ──────────────────────────────────────────────────────
footer = sec.footer
for p in footer.paragraphs:
    p.clear()

ft = footer.add_table(1, 3, Cm(18))
ft.alignment = WD_TABLE_ALIGNMENT.CENTER
flc = ft.cell(0, 0)
fmc = ft.cell(0, 1)
frc = ft.cell(0, 2)
for c in [flc, fmc, frc]:
    no_borders(c)
    set_cell_margins(c, 0, 0, 40, 40)

# Gold separator line above footer
def add_footer_separator(footer_cell):
    tcPr = footer_cell._tc.get_or_add_tcPr()
    tcB = OxmlElement('w:tcBorders')
    top = OxmlElement('w:top')
    top.set(qn('w:val'), 'single')
    top.set(qn('w:sz'), '6')
    top.set(qn('w:space'), '1')
    top.set(qn('w:color'), GOLD)
    tcB.append(top)
    tcPr.append(tcB)

add_footer_separator(flc)
add_footer_separator(fmc)
add_footer_separator(frc)

# Left: School name
p1 = flc.paragraphs[0]
p1.alignment = WD_ALIGN_PARAGRAPH.LEFT
set_spacing(p1, 1, 0)
r1 = p1.add_run('AL NASAR PUBLIC MODEL SCHOOL')
r1.font.name = 'Georgia'
r1.font.size = Pt(7)
r1.bold = True
r1.font.color.rgb = NAVY_RGB

p2 = flc.add_paragraph()
p2.alignment = WD_ALIGN_PARAGRAPH.LEFT
set_spacing(p2, 0, 0)
r2 = p2.add_run('362 J/B Korian  ·  📞 03007201254')
r2.font.name = 'Georgia'
r2.font.size = Pt(6.5)
r2.font.color.rgb = MID_RGB

# Centre: page number
pm = fmc.paragraphs[0]
pm.alignment = WD_ALIGN_PARAGRAPH.CENTER
set_spacing(pm, 2, 0)
fld_begin = OxmlElement('w:fldChar')
fld_begin.set(qn('w:fldCharType'), 'begin')
fld_inst = OxmlElement('w:instrText')
fld_inst.text = ' PAGE '
fld_end = OxmlElement('w:fldChar')
fld_end.set(qn('w:fldCharType'), 'end')
pm_run = pm.add_run()
pm_run._r.append(fld_begin)
pm_run._r.append(fld_inst)
pm_run._r.append(fld_end)
pm_run.font.size = Pt(7)
pm_run.font.color.rgb = GOLD_RGB

# Right: Created by
p3 = frc.paragraphs[0]
p3.alignment = WD_ALIGN_PARAGRAPH.RIGHT
set_spacing(p3, 1, 0)
r3 = p3.add_run('✨  Created & Prepared By  Muhammad Rehan 08  ✨')
r3.font.name = 'Georgia'
r3.font.size = Pt(6.5)
r3.font.color.rgb = GOLD_RGB

# ── SCHOOL NAME HEADER BOX ──────────────────────────────────────
ht = doc.add_table(1, 1)
ht.alignment = WD_TABLE_ALIGNMENT.CENTER
hc = ht.cell(0, 0)
set_bg(hc, NAVY)
set_borders(hc, GOLD, 14)
set_cell_margins(hc, 80, 70, 120, 120)

p_sn = hc.paragraphs[0]
p_sn.alignment = WD_ALIGN_PARAGRAPH.CENTER
set_spacing(p_sn, 2, 0)
r_sn = p_sn.add_run('★  AL NASAR PUBLIC MODEL SCHOOL  ★')
r_sn.font.name = 'Georgia'
r_sn.bold = True
r_sn.font.size = Pt(17)
r_sn.font.color.rgb = WHITE_RGB

p_div = hc.add_paragraph()
p_div.alignment = WD_ALIGN_PARAGRAPH.CENTER
set_spacing(p_div, 0, 0)
r_div = p_div.add_run('▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬')
r_div.font.color.rgb = GOLD_RGB
r_div.font.size = Pt(7)

p_cls = hc.add_paragraph()
p_cls.alignment = WD_ALIGN_PARAGRAPH.CENTER
set_spacing(p_cls, 2, 2)
r_cls = p_cls.add_run('CLASS 6    ◆    FIRST TERM SYLLABUS  +  Summer Vacations  🌞    ◆    SESSION 2026 – 2027')
r_cls.font.name = 'Georgia'
r_cls.bold = True
r_cls.font.size = Pt(10.5)
r_cls.font.color.rgb = GOLD_RGB

# ── INFO CARDS ROW ──────────────────────────────────────────────
gap = doc.add_paragraph()
set_spacing(gap, 3, 0)

it = doc.add_table(1, 3)
it.alignment = WD_TABLE_ALIGNMENT.CENTER

card_data = [
    ('📅  SESSION', '2026 – 2027', NAVY),
    ('📘  TERM', 'First Term', NAVY2),
    ('✍  PREPARED BY', 'Muhammad Rehan 08', NAVY),
]

for i, (label, value, bg_col) in enumerate(card_data):
    c = it.cell(0, i)
    set_bg(c, bg_col)
    set_borders(c, GOLD, 8)
    set_cell_margins(c, 60, 60, 80, 80)

    p_lbl = c.paragraphs[0]
    p_lbl.alignment = WD_ALIGN_PARAGRAPH.CENTER
    set_spacing(p_lbl, 0, 0)
    r_lbl = p_lbl.add_run(label)
    r_lbl.font.name = 'Georgia'
    r_lbl.font.size = Pt(8)
    r_lbl.font.color.rgb = GOLD_RGB
    r_lbl.bold = True

    p_val = c.add_paragraph()
    p_val.alignment = WD_ALIGN_PARAGRAPH.CENTER
    set_spacing(p_val, 1, 0)
    r_val = p_val.add_run(value)
    r_val.font.name = 'Georgia'
    r_val.font.size = Pt(10)
    r_val.font.color.rgb = WHITE_RGB
    r_val.bold = True

# ── IMPORTANT NOTES BANNER ──────────────────────────────────────
gap2 = doc.add_paragraph()
set_spacing(gap2, 4, 0)

nt = doc.add_table(1, 1)
nt.alignment = WD_TABLE_ALIGNMENT.CENTER
nc = nt.cell(0, 0)
set_bg(nc, WARN_RED)
set_borders(nc, 'FFFFFF', 0)
set_cell_margins(nc, 50, 50, 100, 100)

p_nt = nc.paragraphs[0]
p_nt.alignment = WD_ALIGN_PARAGRAPH.CENTER
set_spacing(p_nt, 0, 0)
r_nt = p_nt.add_run(
    '⚠   IMPORTANT :  🌴  Summer Vacation: 15 June – 1 August 2026     |     '
    '📄  First Term papers will be prepared STRICTLY from this syllabus'
)
r_nt.font.name = 'Georgia'
r_nt.font.size = Pt(8.5)
r_nt.bold = True
r_nt.font.color.rgb = WHITE_RGB

# ── INTRO + OBJECTIVES (2-column table) ─────────────────────────
gap3 = doc.add_paragraph()
set_spacing(gap3, 4, 0)

iot = doc.add_table(1, 2)
iot.alignment = WD_TABLE_ALIGNMENT.CENTER
ic  = iot.cell(0, 0)   # Intro (right side / urdu)
oc  = iot.cell(0, 1)   # Objectives

# Intro cell (right column for Urdu, so visually it reads right-to-left)
set_bg(ic, LGOLD)
set_borders(ic, GOLD, 6)
set_cell_margins(ic, 60, 60, 80, 80)

p_intro_hdr = ic.paragraphs[0]
pPr = p_intro_hdr._p.get_or_add_pPr()
pPr.append(OxmlElement('w:bidi'))
jc = OxmlElement('w:jc')
jc.set(qn('w:val'), 'right')
pPr.append(jc)
set_spacing(p_intro_hdr, 0, 2)
r_ih = p_intro_hdr.add_run('تعارف')
apply_urdu_font(r_ih, 11, True, NAVY_RGB)

intro_lines = [
    'پیارے طلبائے کرام! اَلنَّصر پبلک ماڈل اسکول میں آپ کا دلی خیر مقدم ہے۔',
    'یہ مکمل نصابِ تعلیم آپ کی پہلی سہ ماہی کا مستند رہنما دستاویز ہے۔',
    'ہر مضمون کو توجہ، لگن اور دلجمعی سے پڑھیں، مسلسل مشق کریں اور وقت کا',
    'بہترین استعمال کریں۔ محنت، ایمانداری اور ثابت قدمی سے کامیابی یقینی ہے!',
]
for line in intro_lines:
    u_para(ic, line, size=8.5, color=DARK_RGB, sp_b=0, sp_a=0)

# Objectives cell
set_bg(oc, ALTBLUE)
set_borders(oc, GOLD, 6)
set_cell_margins(oc, 60, 60, 80, 80)

p_obj_hdr = oc.paragraphs[0]
pPr2 = p_obj_hdr._p.get_or_add_pPr()
pPr2.append(OxmlElement('w:bidi'))
jc2 = OxmlElement('w:jc')
jc2.set(qn('w:val'), 'right')
pPr2.append(jc2)
set_spacing(p_obj_hdr, 0, 2)
r_oh = p_obj_hdr.add_run('مقاصد')
apply_urdu_font(r_oh, 11, True, NAVY_RGB)

obj_lines = [
    '۱۔  ہر مضمون میں علمی بنیاد کو مضبوط اور پائیدار بنانا۔',
    '۲۔  پڑھنے، لکھنے، سمجھنے اور تجزیہ کرنے کی صلاحیت نکھارنا۔',
    '۳۔  نظم و ضبط، باقاعدگی اور مطالعے کی مستقل عادت راسخ کرنا۔',
    '۴۔  پہلی سہ ماہی کے امتحانات میں پراعتماد اور شاندار کارکردگی۔',
]
for line in obj_lines:
    u_para(oc, line, size=8.5, color=DARK_RGB, sp_b=0, sp_a=1)

# ── SYLLABUS TABLE ──────────────────────────────────────────────
gap4 = doc.add_paragraph()
set_spacing(gap4, 5, 0)

# Table header label
syl_hdr_p = doc.add_paragraph()
syl_hdr_p.alignment = WD_ALIGN_PARAGRAPH.CENTER
set_spacing(syl_hdr_p, 0, 2)
r_sh = syl_hdr_p.add_run('✦   FIRST TERM — COURSE OUTLINE   ✦')
r_sh.font.name = 'Georgia'
r_sh.font.size = Pt(10)
r_sh.bold = True
r_sh.font.color.rgb = NAVY_RGB

# Subjects data: (subject_name, is_urdu, [content lines])
subjects = [
    ('اُردو', True, [
        'اسباق: سبق ۱ تا ۷ بمعہ تمام مشقیں',
        'خطوط: چچا کے نام (گھڑی کا تحفہ) ◂ چھوٹے بھائی کے نام محنت کی تلقین',
        'مضامین: ہمارا وطن ◂ ہمارے پیارے رسول حضرت محمد ﷺ',
        'کہانیاں: جیسا کرو گے ویسا بھرو گے ◂ خوشامد بُری بلا ہے',
        'درخواستیں: دوبارہ داخلہ ◂ فیس معافی',
        'گرامر: اسم کی اقسام ◂ اسم معرفہ کی اقسام',
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

# Build table: col0=Subject, col1=Content
st = doc.add_table(1 + len(subjects), 2)
st.alignment = WD_TABLE_ALIGNMENT.CENTER

# Header row
shdr_subj = st.cell(0, 0)
shdr_cont = st.cell(0, 1)
for c in [shdr_subj, shdr_cont]:
    set_bg(c, NAVY)
    set_borders(c, GOLD, 8)
    set_cell_margins(c, 50, 50, 80, 80)

p_hs = shdr_subj.paragraphs[0]
p_hs.alignment = WD_ALIGN_PARAGRAPH.CENTER
set_spacing(p_hs, 0, 0)
r_hs = p_hs.add_run('SUBJECT')
r_hs.font.name = 'Georgia'
r_hs.font.size = Pt(9.5)
r_hs.bold = True
r_hs.font.color.rgb = GOLD_RGB

p_hc = shdr_cont.paragraphs[0]
p_hc.alignment = WD_ALIGN_PARAGRAPH.CENTER
set_spacing(p_hc, 0, 0)
r_hc = p_hc.add_run('COURSE CONTENT')
r_hc.font.name = 'Georgia'
r_hc.font.size = Pt(9.5)
r_hc.bold = True
r_hc.font.color.rgb = GOLD_RGB

# Set column widths
for row in st.rows:
    row.cells[0].width = Cm(3.2)
    row.cells[1].width = Cm(14.8)

# Subject rows
for idx, (subj_name, is_urdu_subj, content_lines) in enumerate(subjects):
    row_idx = idx + 1
    bg_hex = LGOLD if idx % 2 == 0 else ALTBLUE

    sc = st.cell(row_idx, 0)  # Subject name cell
    cc = st.cell(row_idx, 1)  # Content cell

    set_bg(sc, bg_hex)
    set_bg(cc, bg_hex)
    set_borders(sc, GOLD, 5)
    set_borders(cc, GOLD, 5)
    set_cell_margins(sc, 50, 50, 70, 60)
    set_cell_margins(cc, 45, 45, 80, 60)
    sc.vertical_alignment = WD_ALIGN_VERTICAL.CENTER

    # Subject name
    p_subj = sc.paragraphs[0]
    set_spacing(p_subj, 0, 0)
    if is_urdu_subj:
        pPr = p_subj._p.get_or_add_pPr()
        pPr.append(OxmlElement('w:bidi'))
        jc = OxmlElement('w:jc')
        jc.set(qn('w:val'), 'center')
        pPr.append(jc)
        r_subj = p_subj.add_run(subj_name)
        apply_urdu_font(r_subj, 10, True, NAVY_RGB)
    else:
        p_subj.alignment = WD_ALIGN_PARAGRAPH.CENTER
        r_subj = p_subj.add_run(subj_name)
        r_subj.font.name = 'Georgia'
        r_subj.font.size = Pt(10)
        r_subj.bold = True
        r_subj.font.color.rgb = NAVY_RGB

    # Content lines
    first = True
    for line in content_lines:
        if first:
            cp = cc.paragraphs[0]
            first = False
        else:
            cp = cc.add_paragraph()
        set_spacing(cp, 0, 1)

        if is_urdu_subj:
            pPr = cp._p.get_or_add_pPr()
            pPr.append(OxmlElement('w:bidi'))
            jc = OxmlElement('w:jc')
            jc.set(qn('w:val'), 'right')
            pPr.append(jc)
            r_cl = cp.add_run(line)
            apply_urdu_font(r_cl, 8.5, False, DARK_RGB)
        else:
            cp.alignment = WD_ALIGN_PARAGRAPH.LEFT
            r_cl = cp.add_run(line)
            r_cl.font.name = 'Georgia'
            r_cl.font.size = Pt(8.5)
            r_cl.font.color.rgb = DARK_RGB

# ── PARENTS GUIDELINES ──────────────────────────────────────────
gap5 = doc.add_paragraph()
set_spacing(gap5, 5, 0)

pgt = doc.add_table(1, 1)
pgt.alignment = WD_TABLE_ALIGNMENT.CENTER
pgc = pgt.cell(0, 0)
set_bg(pgc, '1A2C56')
set_borders(pgc, GOLD, 10)
set_cell_margins(pgc, 60, 60, 100, 100)

p_pgh = pgc.paragraphs[0]
pPr = p_pgh._p.get_or_add_pPr()
pPr.append(OxmlElement('w:bidi'))
jc = OxmlElement('w:jc')
jc.set(qn('w:val'), 'center')
pPr.append(jc)
set_spacing(p_pgh, 0, 3)
r_pgh = p_pgh.add_run('❖   والدین کے لیے ضروری ہدایات   ❖')
apply_urdu_font(r_pgh, 11, True, GOLD_RGB)

parents_guidelines = [
    '۱۔  والدین اس بات کو یقینی بنائیں کہ بچہ روزانہ کا سبق اور مشق گھر پر باقاعدگی سے مکمل کرے۔',
    '۲۔  نوٹ بکس کی روزانہ جانچ کریں اور کلاس ٹیچر کے ساتھ مسلسل رابطے میں رہیں۔',
    '۳۔  اگر بچے کا کام مکمل نہ ہو تو اُنہیں امتحان میں بیٹھنے کی اجازت نہیں دی جائے گی۔',
    '۴۔  بچوں کو وقت پر اسکول بھیجیں — غیر حاضری اور تاخیر سے سختی سے گریز کریں۔',
    '۵۔  یونیفارم، صفائی، کتب اور نظم و ضبط کا ہر وقت خاص خیال رکھیں۔',
    '۶۔  گرمیوں کی چھٹیاں ۱۵ جون تا یکم اگست ہوں گی؛ تمام بچے ہوم ورک مکمل کر کے واپس آئیں۔',
]
for line in parents_guidelines:
    u_para(pgc, line, size=8.5, color=WHITE_RGB, sp_b=0, sp_a=1)

# ── STUDY TIPS STRIP ────────────────────────────────────────────
gap6 = doc.add_paragraph()
set_spacing(gap6, 4, 0)

tips_t = doc.add_table(1, 3)
tips_t.alignment = WD_TABLE_ALIGNMENT.CENTER

tips = [
    ('📝  STUDY DAILY', 'Revise every lesson & complete exercises the same day.'),
    ('📚  WRITE NEATLY', 'Maintain clean, well-organised notebooks for every subject.'),
    ('⏰  BE ON TIME', 'Punctuality and full attendance build strong learning habits.'),
]

for i, (tip_title, tip_text) in enumerate(tips):
    tc = tips_t.cell(0, i)
    set_bg(tc, LGOLD if i % 2 == 0 else ALTBLUE)
    set_borders(tc, GOLD, 6)
    set_cell_margins(tc, 55, 55, 70, 70)

    p_tt = tc.paragraphs[0]
    p_tt.alignment = WD_ALIGN_PARAGRAPH.CENTER
    set_spacing(p_tt, 0, 1)
    r_tt = p_tt.add_run(tip_title)
    r_tt.font.name = 'Georgia'
    r_tt.font.size = Pt(8.5)
    r_tt.bold = True
    r_tt.font.color.rgb = NAVY_RGB

    p_tb = tc.add_paragraph()
    p_tb.alignment = WD_ALIGN_PARAGRAPH.CENTER
    set_spacing(p_tb, 0, 0)
    r_tb = p_tb.add_run(tip_text)
    r_tb.font.name = 'Georgia'
    r_tb.font.size = Pt(7.5)
    r_tb.font.color.rgb = DARK_RGB

# ── GOOD LUCK LINE ──────────────────────────────────────────────
gap7 = doc.add_paragraph()
set_spacing(gap7, 4, 0)

p_gl = doc.add_paragraph()
p_gl.alignment = WD_ALIGN_PARAGRAPH.CENTER
set_spacing(p_gl, 0, 0)
r_gl = p_gl.add_run('😊   GOOD LUCK, DEAR STUDENTS!   😊')
r_gl.font.name = 'Georgia'
r_gl.font.size = Pt(10)
r_gl.bold = True
r_gl.font.color.rgb = NAVY_RGB

p_quote = doc.add_paragraph()
p_quote.alignment = WD_ALIGN_PARAGRAPH.CENTER
set_spacing(p_quote, 1, 0)
r_quote = p_quote.add_run('" Work hard, stay curious, and believe in yourself! "')
r_quote.font.name = 'Georgia'
r_quote.font.size = Pt(8.5)
r_quote.italic = True
r_quote.font.color.rgb = GOLD_RGB

# ── SIGNATURE SECTION ──────────────────────────────────────────
gap8 = doc.add_paragraph()
set_spacing(gap8, 8, 0)

# Section heading
sig_hdr_p = doc.add_paragraph()
sig_hdr_p.alignment = WD_ALIGN_PARAGRAPH.CENTER
set_spacing(sig_hdr_p, 0, 3)
r_sigh = sig_hdr_p.add_run('▬▬▬▬▬▬▬▬▬▬▬    ACKNOWLEDGEMENT  /  تصدیق    ▬▬▬▬▬▬▬▬▬▬▬')
r_sigh.font.name = 'Georgia'
r_sigh.font.size = Pt(8.5)
r_sigh.bold = True
r_sigh.font.color.rgb = NAVY_RGB

# 3-column signature table
sigt = doc.add_table(3, 3)
sigt.alignment = WD_TABLE_ALIGNMENT.CENTER

sig_titles_eng = ['Parents\' Signature', 'Teacher\'s Signature', 'Principal\'s Signature']
sig_titles_urd = ['والدین کے دستخط', 'استاد کے دستخط', 'پرنسپل کے دستخط']

for col_i in range(3):
    # Row 0: Urdu title
    c0 = sigt.cell(0, col_i)
    set_bg(c0, LGOLD)
    set_borders(c0, GOLD, 6)
    set_cell_margins(c0, 50, 40, 80, 80)
    p0 = c0.paragraphs[0]
    pPr = p0._p.get_or_add_pPr()
    pPr.append(OxmlElement('w:bidi'))
    jc = OxmlElement('w:jc'); jc.set(qn('w:val'), 'center'); pPr.append(jc)
    set_spacing(p0, 0, 1)
    r0 = p0.add_run(sig_titles_urd[col_i])
    apply_urdu_font(r0, 9, True, NAVY_RGB)

    p0b = c0.add_paragraph()
    p0b.alignment = WD_ALIGN_PARAGRAPH.CENTER
    set_spacing(p0b, 0, 0)
    r0b = p0b.add_run(sig_titles_eng[col_i])
    r0b.font.name = 'Georgia'
    r0b.font.size = Pt(7.5)
    r0b.bold = True
    r0b.font.color.rgb = NAVY_RGB

    # Row 1: Signature line space
    c1 = sigt.cell(1, col_i)
    set_bg(c1, WHITE)
    set_borders(c1, GOLD, 5)
    set_cell_margins(c1, 30, 30, 80, 80)
    set_row_height(sigt.rows[1], 28, 'exact')

    p1 = c1.paragraphs[0]
    p1.alignment = WD_ALIGN_PARAGRAPH.CENTER
    set_spacing(p1, 0, 0)
    r1s = p1.add_run('________________________')
    r1s.font.name = 'Georgia'
    r1s.font.size = Pt(11)
    r1s.font.color.rgb = GOLD_RGB

    # Row 2: Name + Date
    c2 = sigt.cell(2, col_i)
    set_bg(c2, LGOLD)
    set_borders(c2, GOLD, 5)
    set_cell_margins(c2, 40, 40, 70, 70)

    p2a = c2.paragraphs[0]
    p2a.alignment = WD_ALIGN_PARAGRAPH.LEFT
    set_spacing(p2a, 0, 1)
    r2a = p2a.add_run('Name: ________________________________')
    r2a.font.name = 'Georgia'
    r2a.font.size = Pt(7.5)
    r2a.font.color.rgb = DARK_RGB

    p2b = c2.add_paragraph()
    p2b.alignment = WD_ALIGN_PARAGRAPH.LEFT
    set_spacing(p2b, 0, 0)
    r2b = p2b.add_run('Date: _________________________________')
    r2b.font.name = 'Georgia'
    r2b.font.size = Pt(7.5)
    r2b.font.color.rgb = DARK_RGB

# ══════════════════════════════════════════════════════════════════
# SAVE DOCX
# ══════════════════════════════════════════════════════════════════
out_docx = '/home/user/my--repo/AL_NASAR_Premium_Syllabus_2026.docx'
doc.save(out_docx)
print(f'DOCX saved: {out_docx}')
