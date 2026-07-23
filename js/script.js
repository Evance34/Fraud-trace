/* ==========================================================
   FRAUD TRACE
   Main JavaScript
========================================================== */

document.addEventListener("DOMContentLoaded", () => {

    console.log("Fraud Trace Loaded Successfully");

    initializeScrollButton();
    initializeSmoothScrolling();
    initializeStickyHeader();
    initializeFadeAnimation();
    initializeFormValidation();

    initializeFileValidation();
    initializeCharacterCounter();
    initializeLoadingButton();
    initializeDraftStorage();

});

/* ==========================================================
   SCROLL TO TOP BUTTON
========================================================== */

function initializeScrollButton() {

    const topBtn = document.getElementById("topBtn");

    if (!topBtn) return;

    window.addEventListener("scroll", () => {

        if (window.scrollY > 300) {

            topBtn.style.display = "flex";

        } else {

            topBtn.style.display = "none";

        }

    });

    topBtn.addEventListener("click", () => {

        window.scrollTo({

            top: 0,

            behavior: "smooth"

        });

    });

}

/* ==========================================================
   SMOOTH SCROLL
========================================================== */

function initializeSmoothScrolling() {

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {

        anchor.addEventListener("click", function (e) {

            const target = document.querySelector(this.getAttribute("href"));

            if (!target) return;

            e.preventDefault();

            target.scrollIntoView({

                behavior: "smooth"

            });

        });

    });

}

/* ==========================================================
   STICKY HEADER EFFECT
========================================================== */

function initializeStickyHeader() {

    const header = document.querySelector("header");

    if (!header) return;

    window.addEventListener("scroll", () => {

        if (window.scrollY > 80) {

            header.style.boxShadow = "0 10px 35px rgba(0,0,0,.15)";

            header.style.background = "#ffffff";

        }

        else {

            header.style.boxShadow = "0 5px 20px rgba(0,0,0,.05)";

        }

    });

}

/* ==========================================================
   FADE IN ANIMATION
========================================================== */

function initializeFadeAnimation() {

    const elements = document.querySelectorAll(

        ".service-card,.fraud-card,.step,.testimonial,.stat-card,.faq-item,.contact-box"

    );

    if (!elements.length) return;

    const observer = new IntersectionObserver(entries => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {

                entry.target.style.opacity = "1";

                entry.target.style.transform = "translateY(0)";

            }

        });

    }, {

        threshold: 0.20

    });

    elements.forEach(el => {

        el.style.opacity = "0";

        el.style.transform = "translateY(40px)";

        el.style.transition = ".8s ease";

        observer.observe(el);

    });

}

/* ==========================================================
   FORM VALIDATION
========================================================== */

function initializeFormValidation() {

    const form = document.getElementById("complaintForm");

    if (!form) return;

    form.addEventListener("submit", function (event) {

        event.preventDefault();

        const fullName = form.fullname.value.trim();

        const email = form.email.value.trim();

        const phone = form.phone.value.trim();

        const description = form.description.value.trim();

        if (fullName.length < 3) {

            alert("Please enter your full name.");

            return;

        }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(email)) {

            alert("Please enter a valid email address.");

            return;

        }

        if (phone.length < 7) {

            alert("Please enter a valid phone number.");

            return;

        }

        if (description.length < 50) {

            alert("Please provide more details about the incident (minimum 50 characters).");

            return;

        }

        alert("Your complaint has been validated successfully. Backend submission will be connected in the next phase.");

        form.reset();

    });

}
/* ==========================================================
   FILE VALIDATION
========================================================== */

function initializeFileValidation() {

    const fileInput = document.querySelector('input[type="file"]');

    if (!fileInput) return;

    const allowedTypes = [

        "image/jpeg",

        "image/png",

        "application/pdf",

        "application/msword",

        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",

        "text/plain",

        "application/zip",

        "application/x-zip-compressed"

    ];

    const maxFileSize = 10 * 1024 * 1024; // 10MB

    fileInput.addEventListener("change", function () {

        const files = this.files;

        for (let i = 0; i < files.length; i++) {

            const file = files[i];

            if (!allowedTypes.includes(file.type)) {

                alert(file.name + " is not a supported file type.");

                this.value = "";

                return;

            }

            if (file.size > maxFileSize) {

                alert(file.name + " exceeds the 10MB upload limit.");

                this.value = "";

                return;

            }

        }

    });

}

/* ==========================================================
   DESCRIPTION CHARACTER COUNTER
========================================================== */

function initializeCharacterCounter() {

    const textarea = document.querySelector(

        'textarea[name="description"]'

    );

    if (!textarea) return;

    const counter = document.createElement("div");

    counter.style.textAlign = "right";

    counter.style.marginTop = "8px";

    counter.style.color = "#777";

    counter.style.fontSize = "14px";

    textarea.parentNode.appendChild(counter);

    const updateCounter = () => {

        counter.textContent = textarea.value.length + " characters";

    };

    textarea.addEventListener("input", updateCounter);

    updateCounter();

}

/* ==========================================================
   LOADING BUTTON
========================================================== */

function initializeLoadingButton() {

    const form = document.getElementById("complaintForm");

    if (!form) return;

    form.addEventListener("submit", function () {

        const button = form.querySelector("button[type='submit']");

        if (!button) return;

        button.disabled = true;

        button.innerHTML =

            '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';

    });

}

/* ==========================================================
   AUTO SAVE DRAFT
========================================================== */

function initializeDraftStorage() {

    const form = document.getElementById("complaintForm");

    if (!form) return;

    const fields = form.querySelectorAll(

        "input, textarea, select"

    );

    fields.forEach(field => {

        const saved = localStorage.getItem(field.name);

        if (saved !== null) {

            if (

                field.type !== "file" &&

                field.type !== "checkbox"

            ) {

                field.value = saved;

            }

        }

        field.addEventListener("input", () => {

            if (

                field.type !== "file" &&

                field.type !== "checkbox"

            ) {

                localStorage.setItem(

                    field.name,

                    field.value

                );

            }

        });

    });

}

/* ==========================================================
   SUCCESS TOAST
========================================================== */

function showToast(message) {

    const toast = document.createElement("div");

    toast.innerHTML = message;

    toast.style.position = "fixed";

    toast.style.bottom = "30px";

    toast.style.right = "30px";

    toast.style.background = "#00B894";

    toast.style.color = "#fff";

    toast.style.padding = "18px 25px";

    toast.style.borderRadius = "12px";

    toast.style.boxShadow = "0 15px 40px rgba(0,0,0,.2)";

    toast.style.zIndex = "99999";

    toast.style.fontWeight = "600";

    document.body.appendChild(toast);

    setTimeout(() => {

        toast.remove();

    }, 4000);

}