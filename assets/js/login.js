// document.addEventListener("DOMContentLoaded", function () {
//     console.log("DOM ready");

//     const openSignUp = document.getElementById("openSignUp");
//     const dialog = document.getElementById("signUpDialog");

//     console.log(openSignUp, dialog);

//     if (!openSignUp || !dialog) return;

//     openSignUp.addEventListener("click", function (e) {
//         e.preventDefault();
//         console.log("clicked sign up");
//         dialog.showModal();
//     });
// });
/*=============== GSAP ANIMATION ===============*/
const tl = gsap.timeline({});

/* Animate form in the center */
tl.fromTo(
    ".login__content",
    {
        y: -800,
        scaleX: 0.2,
        scaleY: 0.5,
        opacity: 0,
    },
    {
        y: 0,
        scaleX: 0.2,
        scaleY: 0.5,
        opacity: 1,
        duration: 1.5,
        ease: "power3.out",
    },
);

/* Expand vertically */
tl.to(
    ".login__content",
    {
        scaleY: 1,
        duration: 0.6,
        ease: "power3.out",
    },
    "-=0.3",
);

/* Expand horizontally */
tl.to(
    ".login__content",
    {
        scaleX: 1,
        duration: 0.7,
        ease: "power3.out",
    },
    "-=0.2",
);

/* Animate background image */
tl.to(".login__img", {
    scale: 1.08,
    duration: 5,
    ease: "power1.inOut",
    repeat: -1,
    yoyo: true,
    transformOrigin: "center center",
});

/* Animate form */
gsap.defaults({ opacity: 0, y: -60, ease: "power2.out", duration: 1.2 });
gsap.from(".login__title", { delay: 2.5 });
gsap.from(".login__form > *", { delay: 2.7, stagger: 0.2 });
gsap.from(".login__img", {
    y: 0,
    x: 100,
    delay: 3.2,
    ease: "elastic.out(1,0.6)",
});
