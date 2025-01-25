let board_component_data = [
    {
        width: 40.4,
        top: "35px",
        left: "36px",
        height: "80px",
        slots: 2,
        rows: 1
    },
    {
        width: 40.3,
        top: "35px",
        left: "36px",
        height: "80px",
        slots: 3,
        rows: 1
    },

    {
        width: 40.4,
        top: "35px",
        left: "51px",
        height: "80px",
        slots: 4,
        rows: 1
    },

    {
        width: 40.4,
        top: "35px",
        left: "76px",
        height: "80px",
        slots: 6,
        rows: 1
    },
    
    {
        width: 41.5,
        top: "35px",
        left: "51px",
        height: "80px",
        slots: 8,
        rows: 1
    },
    
    {
        width: 43.75,
        top: "31.9999px",
        left: "55.5px",
        height: "87px",
        slots: 4,
        rows: 2
    },

    {
        width: 43.75,
        top: "32px",
        left: "82.5px",
        height: "87px",
        slots: 6,
        rows: 2
    },

    {
        width: 45.5,
        top: "31.99px",
        left: "54.5px",
        height: "87px",
        slots: 8,
        rows: 2
    },

    {
        width: 42.333333333333336,
        top: "31px",
        left: "80px",
        height: "85.5px",
        slots: 6,
        rows: 3
    }
]

const board = document.getElementById("board");
const all_boards = Array.from(document.querySelectorAll(".backplate-selector .item"));

let backplate_selected = false;

let current_container; // to store the container in which the components will be appended
let all_containers = []; // an array of all containers

function get_className(src){
    // RETURNS THE CLASS NAME ONE-LINER, TWO-LINER OR THREE-LINER BASED ON THE SRC
    let src_elements = src.split('/');
    let filename = src_elements[src_elements.length - 1];
    switch(filename){
        case '5.png':
        case '7.png':
        case '8.png':
            return "two-liner";
        case '9.png':
            return "three-liner";
        default:
            return "one-liner";
    }
}

function load_plate(element) {
    try {document.getElementById("intro_text").remove();}catch(error){}
    if(board.childElementCount > 0){
        if(!confirm("All your progress will be lost, are you sure you want to continue?"))
            return;
    }

    board.innerHTML = "";
    all_containers = [];
    board_selected = true;
    next_btn.classList.remove("disabled");

    let backplate_img = document.createElement("img");
    backplate_img.id = "backplate_img";
    backplate_img.src = element.childNodes[1].childNodes[1].src;
    backplate_img.className = get_className(backplate_img.src);

    board_data = board_component_data[all_boards.indexOf(element)];
    
    for(let i = 0; i < board_data.rows; i++){
        let comp_container = document.createElement("div");
        comp_container.className = "component-container";
        comp_container.setAttribute("data-avail", board_data.slots);
        comp_container.style.width = board_data.width * board_data.slots + "px";
        comp_container.style.height = board_data.height;
        comp_container.style.left = board_data.left;
        comp_container.style.top = board_data.top;
        comp_container.style.setProperty("--slot-width", board_data.width + 'px');
        board.appendChild(comp_container);

        all_containers.push(comp_container);
    }

    current_container = document.querySelector("#board .component-container");
    board.appendChild(backplate_img);

    // Removing non compatible components
    let components = document.querySelectorAll(".component-selector .item .image img");

    components.forEach(element => {
        if(get_width(element) > board_data.slots)
            element.parentElement.parentElement.style.display = "none";
        else
            element.parentElement.parentElement.style.display = "flex";
    })

    next_section();
}

function all_slots_filled(){
    let slot_containers = document.querySelectorAll(".component-container");
    let return_val = true;

    slot_containers.forEach(element => {
        let x = parseInt(element.getAttribute("data-avail"));
        if(x != 0)
            return_val = false;
    });
    
    return return_val;
}