
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector("aside");
    const toggleBtn = document.getElementById("sidebar-toggle");
    const brandName = document.querySelector(".admin-name");
    const sidebarTexts = document.querySelectorAll(".sidebar-text");
    const arrows = document.querySelectorAll(".arrow-icon");
    const dropdownContents = document.querySelectorAll(".dropdown-content");
    const dropdownBtns = document.querySelectorAll(".dropdown-btn");
    let isCollapsed = false;

    function expandSidebar() {
        if (isCollapsed) {
            isCollapsed = false;
            sidebar.classList.remove("w-16");
            sidebar.classList.add("w-64");

            sidebarTexts.forEach(text => {
                text.classList.remove("hidden");
            });

            brandName?.classList.remove("hidden");

            arrows.forEach(arrow => {
                arrow.classList.remove("hidden");
            });

            toggleBtn.innerHTML = "←";
        }
    }

    toggleBtn.addEventListener("click", function () {
        isCollapsed = !isCollapsed;

        sidebar.classList.toggle("w-64", !isCollapsed);
        sidebar.classList.toggle("w-16", isCollapsed);

        sidebarTexts.forEach(text => {
            text.classList.toggle("hidden", isCollapsed);
        });

        brandName?.classList.toggle("hidden", isCollapsed);

        arrows.forEach(arrow => {
            arrow.classList.toggle("hidden", isCollapsed);
        });

        if (isCollapsed) {
            dropdownContents.forEach(menu => {
                menu.classList.add("hidden");
            });

            // Reset all arrows to down
            arrows.forEach(arrow => {
                arrow.textContent = "▼";
            });
        }

        toggleBtn.innerHTML = isCollapsed ? "→" : "←";
    });

    window.toggleDropdown = function (id) {
        // First, expand sidebar if collapsed
        if (isCollapsed) {
            expandSidebar();
            // Wait for sidebar to expand, then open dropdown
            setTimeout(() => {
                toggleDropdownInternal(id);
            }, 300);
            return;
        }

        toggleDropdownInternal(id);
    };

    function toggleDropdownInternal(id) {
        const menu = document.getElementById(id);
        const arrowId = id.replace("-menu", "-arrow");
        const arrow = document.getElementById(arrowId);

        // Toggle current dropdown
        const isHidden = menu.classList.toggle("hidden");

        // Update arrow
        if (arrow) {
            arrow.textContent = isHidden ? "▼" : "▲";
        }

        if (!isHidden) {
            dropdownContents.forEach(dropdown => {
                if (dropdown.id !== id && !dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                    const otherArrowId = dropdown.id.replace("-menu", "-arrow");
                    const otherArrow = document.getElementById(otherArrowId);
                    if (otherArrow) otherArrow.textContent = "▼";
                }
            });
        }
    }

    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            if (isCollapsed) {
                e.preventDefault();
                expandSidebar();

                const onclickAttr = this.getAttribute('onclick');
                if (onclickAttr) {
                    const match = onclickAttr.match(/toggleDropdown\('([^']+)'\)/);
                    if (match) {
                        const dropdownId = match[1];
                        setTimeout(() => {
                            toggleDropdownInternal(dropdownId);
                        }, 300);
                    }
                }
            }
        });
    });

    document.addEventListener('click', function (event) {
        if (isCollapsed) return;

        const dropdowns = document.querySelectorAll('.dropdown-container');
        let clickedInsideDropdown = false;

        dropdowns.forEach(dropdown => {
            if (dropdown.contains(event.target)) {
                clickedInsideDropdown = true;
            }
        });

        if (!clickedInsideDropdown) {
            dropdownContents.forEach(menu => {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                    const arrowId = menu.id.replace("-menu", "-arrow");
                    const arrow = document.getElementById(arrowId);
                    if (arrow) arrow.textContent = "▼";
                }
            });
        }
    });
});