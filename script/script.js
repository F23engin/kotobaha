
// nav
const topArticle = document.getElementById('top');
const navTargetTop = document.getElementById('navTargetTop');

topArticle.addEventListener('mouseover', function(){
    navTargetTop.classList.add('activeNav');
});
topArticle.addEventListener('mouseleave', function(){
    navTargetTop.classList.remove('activeNav');
});


const projectArticle = document.getElementById('project');
const navTargetProject = document.getElementById('navTargetProject');

projectArticle.addEventListener('mouseover', function(){
        navTargetProject.classList.add('activeNav');
});
projectArticle.addEventListener('mouseleave', function(){
        navTargetProject.classList.remove('activeNav');
});


const aboutArticle = document.getElementById('about');
const navTargetAbout = document.getElementById('navTargetAbout');

aboutArticle.addEventListener('mouseover', function(){
        navTargetAbout.classList.add('activeNav');
});
aboutArticle.addEventListener('mouseleave', function(){
        navTargetAbout.classList.remove('activeNav');
});


const contactArticle = document.getElementById('contact');
const navTargetContact = document.getElementById('navTargetContact');

contactArticle.addEventListener('mouseover', function(){
        navTargetContact.classList.add('activeNav');
});
contactArticle.addEventListener('mouseleave', function(){
        navTargetContact.classList.remove('activeNav');
});

// link 
$(function() {
    $('a[href^="#"]').click(function(){
        const adjust = 0;
        const speed = 1000;
        const href = $(this).attr("href");
        const target = $(href == "#" || href == "" ? 'html' : href);
        const position = target.offset().top + adjust;
        $('body,html').animate({scrollTop:position}, speed, 'swing');
        return false;
    });
});

// scrollreveal
ScrollReveal().reveal('.content-section', {
    delay: 300,
    distance: '100px',
    duration: 1500,
    opacity: 0,
    origin: 'bottom',
    scale:  0.9,
    desctop: true,
    mobile: true,
    reset: false
});