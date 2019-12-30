class SideBarController {
    constructor() {
        this.h1Container = document.getElementById("h1Container");

        this.sideBar = document.getElementById("sidebar");
        this.sideBarContent = document.getElementById("sidebarContent");
        this.projectsLinks = document.getElementsByTagName("h2");

        this.slider = document.getElementById("slider");
        this.sliderDefault = document.getElementById("sliderDefault");
        this.sliderImgContainer = document.getElementById("sliderImgContainer");
        this.sliderTitle = document.getElementById("sliderProjectTitle");

        this.projectSelected = null;
        this.state = false;
    };

    changeState() {
        return this.state = true;
    };

    displaySlider() {
        this.sliderDefault.classList.add("invisible");
        this.sideBarContent.classList.add("fontSizeReduce");
        this.h1Container.classList.add("smaller");
        this.sliderDefault.classList.add("fadeOut");
        this.sideBar.classList.add("smaller");
        this.slider.classList.add("bigger");

        setTimeout(() => {
            this.sliderTitle.classList.remove("invisible");
            this.sliderImgContainer.classList.remove("invisible");
            this.sliderImgContainer.classList.add("fadeIn");
        },500);
    };

    displayProjectSelected(i) {
        if (this.projectSelected) {
            this.projectSelected.classList.remove("projectSelected");
        }

        this.projectsLinks[i].classList.add("projectSelected");
        this.projectSelected = this.projectsLinks[i];
    };

    addTitleAnimation(i) {
        this.projectsLinks[i].classList.add("titleMouseOver");
    };

    removeTitleAnimation(i) {
        setTimeout(() => {
            this.projectsLinks[i].classList.remove("titleMouseOver");
        }, 200);
    };

    initControls() {
        for (let i = 0; i < this.projectsLinks.length; i++) {
            this.projectsLinks[i].addEventListener("click", () => {
                if (!this.state) {
                    this.changeState();
                    this.displaySlider();
                }

                this.displayProjectSelected(i);
            });

            this.projectsLinks[i].addEventListener("mouseover", () => {
                this.addTitleAnimation(i);
            });

            this.projectsLinks[i].addEventListener("mouseout", () => {
                this.removeTitleAnimation(i);
            });
        }
    };
}

let sideBarController = new SideBarController();
sideBarController.initControls();