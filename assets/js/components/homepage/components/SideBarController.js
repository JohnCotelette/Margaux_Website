import Ajax from "../../ajax/Ajax";

class SideBarController extends Ajax {
    constructor() {
        super();
        this.header = document.getElementsByTagName("header");
        this.h1Container = document.getElementById("h1Container");

        this.sideBar = document.getElementById("sidebar");
        this.sideBarContent = document.getElementById("sidebarScrollable");
        this.projectsLinks = document.getElementsByTagName("h2");

        this.slider = document.getElementById("slider");
        this.sliderDefault = document.getElementById("sliderDefault");
        this.sliderImgContainer = document.getElementById("sliderImgContainer");
        this.sliderScrollable = document.getElementById("sliderScrollable");
        this.sliderTitle = document.getElementById("sliderProjectTitle");

        this.projectSelected = null;
        this.state = false;
    };

    changeState() {
        return this.state = true;
    };

    resetSlider() {
        this.sliderImgContainer.classList.add("notVisible");

        while (this.sliderScrollable.firstChild) {
            this.sliderScrollable.firstChild.remove();
        }
    };

    getPictures(projectId) {
        this.getData("/api/projects/" + projectId + "/pictures", (response) => {
            if (response["picturesLinks"]) {
                this.sliderTitle.textContent = "[" + response["projectDescription"] + "]";

                let picturesLinks = response["picturesLinks"];

                this.resetSlider();

                for (let i = 0; i < picturesLinks.length; i++) {
                    let newPictureContainer = document.createElement("figure");
                    let newPicture = document.createElement("img");

                    newPicture.classList.add("sliderPictures");
                    newPicture.src = "project_img/" + picturesLinks[i];
                    newPicture.alt = response["projectDescription"];

                    newPictureContainer.appendChild(newPicture);
                    this.sliderScrollable.appendChild(newPictureContainer);

                    newPicture.addEventListener("mousedown", (e) => {
                        e.preventDefault();
                    });
                }

                setTimeout(() => {
                    this.sliderImgContainer.classList.remove("notVisible");
                }, 200);
            }
            else {
                this.resetSlider();

                this.sliderTitle.textContent = "[" + response["message"] + "]";
            }
        });
    };

    displaySlider() {
        this.sliderDefault.classList.add("invisible");
        this.header[0].classList.add("headerSmallMobile");
        this.sideBarContent.classList.add("fontSizeReduce");
        this.sideBarContent.classList.add("smallerMobile");
        this.h1Container.classList.add("smaller");
        this.sideBar.classList.add("smaller");
        this.slider.classList.add("bigger");

        setTimeout(() => {
            this.sliderTitle.classList.remove("invisible");
            this.sliderImgContainer.classList.remove("invisible");
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
            this.projectsLinks[i].addEventListener("click", (e) => {
                this.getPictures(this.projectsLinks[i].getAttribute("data-projectId"));

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