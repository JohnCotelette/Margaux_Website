class Canvas {
    constructor() {
        this.canvasContainer = document.getElementById("sliderDefault");
        this.canvas = document.getElementById("drawToMakeAppear");
        this.haveToDisapearSymbols = document.getElementsByClassName("haveToDisapear");

        this.dessin = null;
        this.ctx = this.canvas.getContext("2d");

        this.backgroundColor = "white";
    };

    getPosition(e) {
        let typeE = e.type;
        let rect = this.canvas.getBoundingClientRect();
        if (typeE === "mousemove") {
            return {
                x: e.clientX - rect.left,
                y: e.clientY - rect.top
            };
        } else {
            return {
                x: e.touches[0].clientX - rect.left,
                y: e.touches[0].clientY - rect.top
            };
        }
    };

    movePosition(e) {
        let MousePosition = this.getPosition(e);
        let positionX = MousePosition.x;
        let positionY = MousePosition.y;
        this.draw(positionX, positionY);
    };

    startDraw(e) {
        this.dessin = true;
        this.draw(e);
    };

    endDraw() {
        this.dessin = false;
        this.ctx.beginPath();
    };

    draw(positionX, positionY) {
        if(!this.dessin) return;

        this.ctx.globalCompositeOperation = "destination-out";
        this.ctx.shadowBlur = 20;
        this.ctx.shadowColor = "black";

        this.ctx.lineWidth = 100;
        this.ctx.lineCap = "round";

        this.ctx.lineTo(positionX, positionY);
        this.ctx.stroke();
        this.ctx.beginPath();
        this.ctx.moveTo(positionX, positionY);
    };

    hideSymbols(symbol) {
        console.log("lol");
        symbol.classList.add("notVisible");
    }

    init() {
        this.ctx.canvas.width = this.canvasContainer.clientWidth + 1000;
        this.ctx.canvas.height = this.canvasContainer.clientHeight + 600;

        this.ctx.fillStyle = this.backgroundColor;
        this.ctx.fillRect(0,0, this.canvas.width, this.canvas.height);
    }

    initControls() {
        this.canvas.addEventListener("mouseover", this.startDraw.bind(this));
        this.canvas.addEventListener("mouseout", this.endDraw.bind(this));
        this.canvas.addEventListener("mousemove", this.movePosition.bind(this));

        this.haveToDisapearSymbols.forEach((symbol) => {
            symbol.addEventListener("mousemove", () => {
               this.hideSymbols(symbol);
            });
        });
    };
}

let canvas = new Canvas();

canvas.init();
canvas.initControls();