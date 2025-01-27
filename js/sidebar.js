let global_components_list = [];
let all_icons = [];
let selected_holder;

let containers = document.querySelectorAll(".container");
let icon_selector = document.querySelector(".icon-selector");
let all_icon_holders;

let container_index = 0;
let board_selected = false;
let is_plate_selected = false;

const back_btn = document.getElementById("back");
const next_btn = document.getElementById("next");
const download_btn = document.querySelector("#download_svg");
const section_title_holder = document.querySelector(".section-title");
const section_titles = ["Choose Backplate", "Choose Components", "Choose Icons", "Choose Top-plate"];

function filter_icons(element) {
    if (element.classList.contains("switch-holder")) {
        icon_selector.classList.remove("fan-only");
        icon_selector.classList.add("switch-only");
    } else if (element.classList.contains("fan-holder")) {
        icon_selector.classList.remove("switch-only");
        icon_selector.classList.add("fan-only");
    }
}

function select_holder(element) {
    if (selected_holder)
        selected_holder.classList.remove("selected-holder");

    if (!element.className.includes("icon-holder"))
        element = element.childNodes[0];

    selected_holder = element;
    selected_holder.classList.add("selected-holder");

    if (selected_holder.classList.contains("up")) {
        document.querySelector(".icon-selector").classList.add("up");
    } else {
        document.querySelector(".icon-selector").classList.remove("up");
    }

    if (selected_holder.classList.contains("down")) {
        document.querySelector(".icon-selector").classList.add("down");
    } else {
        document.querySelector(".icon-selector").classList.remove("down");
    }

    if (selected_holder.classList.contains("bell")) {
        document.querySelector(".icon-selector").classList.add("bell");
    } else {
        document.querySelector(".icon-selector").classList.remove("bell");
    }

    filter_icons(selected_holder.parentElement);
}

function unselect_holder() {
    if (selected_holder) {
        selected_holder.classList.remove("selected-holder");
        selected_holder = undefined;
    }
}

function next_section() {
    if (!board_selected)
        return alert("Please select a board to continue");

    if (container_index == 1) {
        if (!all_slots_filled()) {
            alert("Please fill all the slots");
            return;
        } else {
            global_components_list = [];
            all_containers.forEach(element => {
                element.childNodes.forEach(e => { global_components_list.push(e) })
            });
            all_icon_holders = Array.from(document.querySelectorAll(".icon-holder"));

            if (all_icons_filled())
                setTimeout(() => {
                    next_section();
                }, 301);

            for (let index = 0; index < all_icon_holders.length; index++) {
                const element = all_icon_holders[index];
                if (element.childElementCount == 0) {
                    select_holder(element);
                    break;
                }
            }
        }
    }

    if (container_index == 2) {
        if (!all_icons_filled()) {
            return alert("Please fill all icons");
        }
    }

    if (back_btn.classList.contains("disabled")) {
        back_btn.classList.remove("disabled");
        back_btn.onclick = prev_section;
    }

    let current_container = containers[container_index];
    current_container.style.opacity = 0;

    setTimeout(() => {
        current_container.style.display = "none";
        container_index++;
        let all_delete_btns = document.querySelectorAll(".delete-btn");
        if (container_index == 1) {
            all_delete_btns.forEach(btn => {
                btn.style.display = "block";
            })
        } else {
            all_delete_btns.forEach(btn => {
                btn.style.display = "none";
            })
        }
        section_title_holder.innerHTML = section_titles[container_index];
        current_container = containers[container_index];
        current_container.style.display = (container_index == 1) ? "flex" : "grid";
        current_container.style.opacity = 1;
    }, 300);

    if (container_index == 2) {
        unselect_holder();
        next_btn.classList.add("disabled");
        document.body.style.setProperty("--icon-holder-outline-weight", "0px");
        next_btn.innerHTML = "Download as PNG";
        next_btn.onclick = () => {
            if (is_plate_selected) {
                const myDiv = document.getElementById('board');
                let initial_scale = getComputedStyle(myDiv)["scale"];

                myDiv.style.scale = 1;
                setTimeout(() => {
                    html2canvas(myDiv, { scale: 10 }).then(function (canvas) {
                        const dataUrl = canvas.toDataURL();
                        const link = document.createElement('a');
                        link.download = 'My G6 Board.png';
                        link.href = dataUrl;
                        link.click();
                        setTimeout(() => {
                            if (initial_scale)
                                myDiv.style.scale = initial_scale;
                            else
                                myDiv.style.scale = "1";
                        }, 500);
                    });
                }, 200);
            }
            else {
                return alert("Please select top plate");
            }
        };
        download_btn.style.display = "block";
    }
}

function prev_section() {
    let current_container = containers[container_index];
    current_container.style.opacity = 0;

    if (container_index == 2) {
        unselect_holder();
    }

    if (container_index == 3) {
        if (is_plate_selected) {
            if (!confirm("Your top-plate selection will be lost")) return;
        }
        console.log("Setting back to opacity 1");
        document.body.style.setProperty("--blanking-plate-opacity", "1");
        document.body.style.setProperty("--icon-holder-outline-weight", "2px");
        next_btn.innerText = "Next";
        next_btn.onclick = next_section;

        let board_container = document.getElementById("board");
        let bottom_logo = document.getElementById("bottom-logo");
        board_container.classList.remove("top-plate-selected");
        let top_plate = document.getElementById("top-plate-img");
        is_plate_selected = false;

        download_btn.style.display = "none";
        download_btn.classList.add("disabled");

        if (top_plate)
            top_plate.remove();
        if (bottom_logo)
            bottom_logo.remove();
    }

    setTimeout(() => {
        current_container.style.display = "none";
        container_index--;
        let all_delete_btns = document.querySelectorAll(".delete-btn");
        if (container_index == 1) {
            all_delete_btns.forEach(btn => {
                btn.style.display = "block";
            })
        } else {
            all_delete_btns.forEach(btn => {
                btn.style.display = "none";
            })
        }
        section_title_holder.innerHTML = section_titles[container_index];
        current_container = containers[container_index];
        current_container.style.display = (container_index == 1) ? "flex" : "grid";
        current_container.style.opacity = 1;

        if (container_index == 0) {
            back_btn.classList.add("disabled");
            back_btn.onclick = () => { };
        }
        if (next_btn.classList.contains("disabled")) {
            next_btn.classList.remove("disabled");
            next_btn.onclick = next_section;
        }
    }, 300);
}

function all_icons_filled() {
    let all_icon_holders = document.querySelectorAll(".switch-icon-holder");
    let all_fan_icon_holders = document.querySelectorAll(".fan-icon-holder");

    let return_value = true;

    all_icon_holders.forEach(element => {
        if (element.childNodes.length == 0) {
            return_value = false;
        }
    });

    all_fan_icon_holders.forEach(element => {
        if (element.childNodes.length == 0) {
            return_value = false;
        }
    });

    return return_value;
}

let topplate;

function load_top_plate(e, type) {
    topplate = type;
    download_btn.classList.remove("disabled");

    if (!is_plate_selected) {
        next_btn.classList.remove("disabled");
        document.body.style.setProperty("--blanking-plate-opacity", "0");
        is_plate_selected = true;
        let board_container = document.getElementById("board");
        let backplate_img = document.getElementById("backplate_img");
        let logo = document.createElement("img");
        logo.id = "bottom-logo";
        logo.src = "img/white_logo.png";

        let top_plate_img = document.createElement("div");
        top_plate_img.className = "top-plate-img";
        top_plate_img.id = "top-plate-img";
        top_plate_img.style.height = backplate_img.offsetHeight + "px";
        top_plate_img.style.width = backplate_img.offsetWidth + "px";
        top_plate_img.style.backgroundImage = "url(" + e.target.childNodes[1].childNodes[1].src + ")";

        board_container.classList.add("top-plate-selected");
        board_container.appendChild(top_plate_img);
        board_container.appendChild(logo);
    }
    else {
        let top_plate_img = document.querySelector(".top-plate-img");
        console.log(e.target.childNodes[1]);
        top_plate_img.style.backgroundImage = "url(" + e.target.childNodes[1].childNodes[1].src + ")";
    }
}

function load_icon(e) {
    if (selected_holder) {
        let all_icon_holders = Array.from(document.querySelectorAll(".icon-holder"));
        let current_holder_index = all_icon_holders.indexOf(selected_holder);
        let icon;

        if (e.target.classList.contains("item")) {
            icon = e.target.childNodes[0].childNodes[0];
        } else if (e.target.classList.contains("image")) {
            icon = e.target.childNodes[0];
        } else {
            icon = e.target;
        }

        selected_holder.innerHTML = "";
        selected_holder.appendChild(icon.cloneNode());

        if (all_icons_filled()) {
            next_section();
            unselect_holder();
            return;
        }

        if (current_holder_index == all_icon_holders.length - 1) {
            let move_to_next_section = true;

            for (const element of all_icon_holders) {
                if (element.childElementCount == 0) {
                    select_holder(element);
                    move_to_next_section = false;
                    break;
                }
            }

            if (move_to_next_section)
                return next_section();
        }

        if (!all_icons_filled()) {
            while (all_icon_holders[current_holder_index].childElementCount != 0) {
                current_holder_index++;
                if (current_holder_index == all_icon_holders.length)
                    current_holder_index = 0;
            }

            select_holder(all_icon_holders[current_holder_index]);
        }

        // if(current_holder_index == all_icon_holders.length - 1){
        //     // end of components
        //     // now need to check for any empty icons

        //     if(all_icons_filled()){
        //         next_section();
        //         unselect_holder();
        //     }else{
        //         console.log("All are not filled");
        //         for (let index = 0; index < all_icon_holders.length; index++) {
        //             const element = all_icon_holders[index];
        //             if(element.childElementCount == 0){
        //                 select_holder(element);
        //                 break;
        //             }
        //         }
        //     }
        // }
        // else{
        //     while(true){
        //         if(current_holder_index == all_icon_holders.length - 1){
        //             next_section();
        //             unselect_holder();
        //             break;
        //         }
        //         if(all_icon_holders[++current_holder_index].childElementCount == 0){
        //             select_holder(all_icon_holders[current_holder_index]);
        //             break;
        //         }
        //     }
        // }
    }

    if (all_icons_filled())
        next_section();
}

function holder_selected(e) {
    if (container_index == 2) {
        e.preventDefault();
        e.stopPropagation();
        select_holder(e.target);
    }
}

function get_icon_html(src) {
    let item = document.createElement("div");
    item.className = "item";
    item.onclick = load_icon;

    if (src.length == 3)
        item.classList.add(src[2]);

    let image = document.createElement("div");
    image.className = "image";

    let img = document.createElement("img");
    img.src = "img/icons/" + src[0] + ".png";

    let title = document.createElement("p");
    title.className = "title";
    title.innerHTML = src[1];

    image.appendChild(img);
    item.appendChild(image);
    item.appendChild(title);

    return item;
}

window.onload = () => {
    const all_top_plates = document.querySelectorAll(".topplate-selector .item .image img");

    all_top_plates.forEach(element => {
        element.onclick = (e) => { load_top_plate(e) };
    });

    let icon_container = document.querySelector(".icon-selector");
    icon_desc.forEach(element => {
        icon_container.appendChild(get_icon_html(element));
    })
}

window.onbeforeunload = () => {
    return "All your progress will be lost!";
}