{{-- Shared hover animations for tutor cards (home + best tutors page) --}}
.tutor-photo-wrap-interactive {
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
}
.tutor-photo-wrap-interactive:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 16px 32px rgba(0,0,0,0.18);
}

.subject-tag-interactive {
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.2s, border-color 0.2s, box-shadow 0.3s;
    cursor: pointer;
}
.subject-tag-interactive:hover {
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 6px 12px rgba(37,99,235,0.15);
    background-color: #dbeafe !important;
    border-color: #3b82f6 !important;
    color: #1d4ed8 !important;
}

.text-interactive-hover {
    display: block;
    width: fit-content;
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), color 0.3s ease;
}
.text-interactive-hover:hover {
    transform: translateY(-4px);
}

.button-interactive-hover {
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease, background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease !important;
}
.button-interactive-hover:hover {
    transform: translateY(-3px) scale(1.01);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.badge-interactive-hover {
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
    cursor: pointer;
}
.badge-interactive-hover:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 4px 10px rgba(234, 88, 12, 0.15);
}
