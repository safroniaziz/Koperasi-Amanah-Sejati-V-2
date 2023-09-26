AOS.init();


const sections = document.querySelectorAll("section[id]");

window.addEventListener("scroll", navHighlighter);

function navHighlighter() {

    let scrollY = window.pageYOffset;

    sections.forEach(current => {
        const sectionHeight = current.offsetHeight;
        const sectionTop = current.offsetTop - 50;
        sectionId = current.getAttribute("id");
        if (
            scrollY > sectionTop &&
            scrollY <= sectionTop + sectionHeight
        ) {
            document.querySelector(".menu-navbar a[href*=" + sectionId + "]").classList.add(
                "active-menu");
        } else {
            document.querySelector(".menu-navbar a[href*=" + sectionId + "]").classList.remove(
                "active-menu");
        }
    });
}


if (localStorage.getItem("language-storage") == null) {
    localStorage.setItem('language-storage', 0);
}
let translationSwitcher = function () {
    return {
        selected: localStorage.getItem('language-storage'),
        footer_fh: {
            en: "Faculty of Law",
            id: "Fakultas Hukum",
            de: "Rechtswissenschaftliche Fakultät",
        },
        footer_feb: {
            en: "Faculty of Economics and Business",
            id: "Fakultas Ekonomi dan Bisnis",
            de: "Wirtschaftswissenschaftliche Fakultät",
        },
        footer_isip: {
            en: "Faculty Ilmu Social dan Politics",
            id: "Fakultas Ilmu Sosial dan Politik",
            de: "Fakultät für Sozial- und Politikwissenschaften",
        },
        footer_fp: {
            en: "Faculty of Agriculture",
            id: "Fakultas Pertanian",
            de: "Fakultät der Landwirtschaft",
        },
        footer_ft: {
            en: "Faculty of Engineering",
            id: "Fakultas Teknik",
            de: "Fakultät für Ingenieurwissenschaften",
        },
        footer_fk: {
            en: "Faculty of Medicine",
            id: "Fakultas Kedokteran",
            de: "Medizinische Fakultät",
        },
        nav_unib: {
            en: "University of Bengkulu",
            id: "Universitas Bengkulu",
            de: "Universität Bengkulu",
        },

        countries: [{
                label: "Indonesia",
                lang: "id",
                flag: "id",
            },
            {
                label: "English",
                lang: "en",
                flag: "gb",
            },

            {
                label: "German",
                lang: "de",
                flag: "de",
            },
        ],
        menuToggle: false,
    };
};


// When the user scrolls down 80px from the top of the document, resize the navbar's padding and the logo's font size
window.onscroll = function () {
    scrollFunction()
};

function scrollFunction() {
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        document.getElementById("navbar").style.padding = "10px 25px";
        document.getElementById("navbar").classList.add("nav-scroll");
        document.getElementById("navbar").classList.add("shadow-lg");
        document.getElementById("list-menu").classList.add("list-menu-scroll");
    } else {
        document.getElementById("navbar").style.padding = "15px 25px";
        document.getElementById("navbar").classList.remove("nav-scroll");
        document.getElementById("navbar").classList.remove("shadow-lg");
        document.getElementById("list-menu").classList.remove("list-menu-scroll");
    }
}
