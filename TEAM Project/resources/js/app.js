import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

/* ===== tableSort / reportTableSort / memosTableSort: فرز أعمدة الجداول ===== */
const SORT_ICON_BOTH = `<svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.32"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>`;
const SORT_ICON_ASC  = `<svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#1e40af" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/></svg>`;
const SORT_ICON_DESC = `<svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#1e40af" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7 9 5-5 5 5"/></svg>`;

function sortTableContainer(container, colKey, currentSortCol, currentSortDir) {
    const tbody = container.querySelector('tbody');
    if (!tbody) return { sortCol: colKey, sortDir: 'asc' };

    const dataRows  = Array.from(tbody.querySelectorAll('tr[data-sort-row]'));
    const groupRows = Array.from(tbody.querySelectorAll('tr[data-group-row]'));

    if (dataRows.length === 0) return { sortCol: colKey, sortDir: 'asc' };

    let newDir = 'asc';
    if (currentSortCol === colKey) {
        newDir = currentSortDir === 'asc' ? 'desc' : 'asc';
    }

    // فرز صفوف البيانات
    dataRows.sort((a, b) => {
        const va = (a.getAttribute('data-' + colKey) || '').trim();
        const vb = (b.getAttribute('data-' + colKey) || '').trim();
        const cmp = va.localeCompare(vb, 'ar', { numeric: true, sensitivity: 'base' });
        return newDir === 'asc' ? cmp : -cmp;
    });

    // إزالة وإعادة ترتيب صفوف الـ DOM
    [...groupRows, ...dataRows].forEach(r => r.parentNode && r.parentNode.removeChild(r));

    if (groupRows.length > 0) {
        groupRows.forEach(r => tbody.appendChild(r));
    }
    dataRows.forEach(r => tbody.appendChild(r));

    return { sortCol: colKey, sortDir: newDir };
}

const createSortComponent = () => ({
    sortCol: '',
    sortDir: 'asc',

    sortBy(col) {
        const res = sortTableContainer(this.$el, col, this.sortCol, this.sortDir);
        this.sortCol = res.sortCol;
        this.sortDir = res.sortDir;
    },

    sortIcon(col) {
        if (this.sortCol !== col) return SORT_ICON_BOTH;
        return this.sortDir === 'asc' ? SORT_ICON_ASC : SORT_ICON_DESC;
    }
});

Alpine.data('tableSort', createSortComponent);
Alpine.data('reportTableSort', createSortComponent);
Alpine.data('memosTableSort', createSortComponent);

Alpine.start();
