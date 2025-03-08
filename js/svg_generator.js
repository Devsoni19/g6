function extract_name(src) {
    let components = src.split("/");
    let name = components[components.length - 1].split(".")[0];

    while (name.indexOf("%20") != -1)
        name = name.replace("%20", " ");

    return name.includes("fan_") ? name.split("_")[1] : name;
}

function get_backplate() {
    switch (extract_name(document.querySelector("#backplate_img").src)) {
        case "1":
            return "2M";
        case "2":
            return "3M";
        case "3":
            return "4M";
        case "4":
            return "6M";
        case "5":
            return "8MV";
        case "6":
            return "8M";
        case "7":
            return "12M";
        case "8":
            return "16M";
        case "9":
            return "18M";
    }
}

print_data = {
    module_print_data: []
}

function create_svg() {
    document.querySelector(".top-plate-img").remove();
    let data = document.querySelector(".board-container");
    let backplate_code = get_backplate();
    document.querySelector("#backplate_img").remove();
    document.querySelector("#bottom-logo").remove();
    //	let container_obj = new container(backplate_code);
    add_baseplate_frame(backplate_code);

    data.childNodes.forEach(html_container => {
        if (html_container.nodeType !== Node.TEXT_NODE) {
            let container_obj = new container(backplate_code);
            html_container.childNodes.forEach(module => {
                let obj = {
                    icon_print_list: [],
                    comp_print_list: []
                }
                if (module.nodeType !== Node.TEXT_NODE) {
                    console.log("Adding IR window");
                    console.log("Currently there are " + container_obj.num_of_icons + " icons already");

                    obj["component_name"] = module.getAttribute("data-component-name");

                    switch (module.getAttribute("data-component-name")) {
                        case "Ssw1":
                            container_obj.add_board_frame("Ssw2");
                            break;

                        case "Ssw2":
                        case "Ssw2x2":
                        case "Ssw1x2":
                            container_obj.add_ir_window("Ssw2");
                            container_obj.add_board_frame("Ssw2");
                            break;

                        case "Ssw2F":
                        case "Ssw4":
                            container_obj.add_ir_window("Ssw4");
                            container_obj.add_board_frame("Ssw4");
                            break;

                        case "Ssw4F":
                        case "Ssw6":
                            container_obj.add_ir_window("Ssw6");
                            container_obj.add_board_frame("Ssw6");
                            break;
                    }

                    // Iterating over each module, ignoring the #text childNodes
                    if (module.classList.contains("other-component-holder")) {
                        let x = module.style.backgroundImage;
                        let component_name = extract_name(x.substr(5, x.length - 7));
                        container_obj.add_component(component_name);
                        obj.comp_print_list.push(component_name);
                    }

                    else
                        module.childNodes.forEach(component => {
                            if (component.nodeType !== Node.TEXT_NODE && !component.classList.contains("delete-btn")) {
                                // Iterating over each holder, ignoring the delete-btn and #text nodes
                                if (component.classList.contains("fan-holder")) {
                                    // console.log("fan holder");
                                    // console.log(component.childNodes);
                                    let fan_icon_name = extract_name(component.childNodes[0].childNodes[0].src);
                                    // console.log("Adding fan holder");
                                    container_obj.add_fan(fan_icon_name);
                                    obj.icon_print_list.push(fan_icon_name);
                                }
                                else if (component.classList.contains("one-holder")) {
                                    let icon_list = [];

                                    component.childNodes.forEach(icon_holder => {
                                        if (icon_holder.nodeType !== Node.TEXT_NODE) {
                                            // Iterating over only icon-holder in component, ignoring the text nodes
                                            icon_list.push(extract_name(icon_holder.childNodes[0].src))
                                        }
                                    });
                                    container_obj.add_1_icon(icon_list[0]);
                                    obj.icon_print_list.push(icon_list[0]);
                                }

                                else if (component.classList.contains("one-x-two-holder")) {
                                    //console.log("1x2 switch holder");      
                                    let icon_list = [];

                                    component.childNodes.forEach(icon_holder => {
                                        if (icon_holder.nodeType !== Node.TEXT_NODE) {
                                            // Iterating over only icon-holder in component, ignoring the text nodes
                                            icon_list.push(extract_name(icon_holder.childNodes[0].src))
                                        }
                                    });

                                    // console.log("adding 1x2");
                                    container_obj.add_icon(icon_list[0]);
                                    container_obj.add_2_icon(icon_list[1], icon_list[2]);

                                    obj.icon_print_list.push(icon_list[0]);
                                    obj.icon_print_list.push(icon_list[1]);
                                    obj.icon_print_list.push(icon_list[2]);
                                }

                                else if (component.classList.contains("two-x-two-holder")) {
                                    // console.log("2x2 switch holder");
                                    let icon_list = [];
                                    component.childNodes.forEach(icon_holder => {
                                        if (icon_holder.nodeType !== Node.TEXT_NODE) {
                                            // Iterating over only icon-holder in component, ignoring the text nodes 
                                            icon_list.push(extract_name(icon_holder.childNodes[0].src));
                                            obj.icon_print_list.push(extract_name(icon_holder.childNodes[0].src));
                                        }
                                    });

                                    // console.log("Adding 2x2");
                                    container_obj.add_2_icon(icon_list[0], icon_list[2]);
                                    container_obj.add_2_icon(icon_list[1], icon_list[3]);
                                }

                                else if (component.classList.contains("switch-holder")) {
                                    // console.log("switch holder");
                                    component.childNodes.forEach(icon_holder => {
                                        if (icon_holder.nodeType !== Node.TEXT_NODE) {
                                            // Iterating over only icon-holder in component, ignoring the text nodes
                                            let icon_name = extract_name(icon_holder.childNodes[0].src);
                                            console.log("Icon Name: " + icon_name);
                                            container_obj.add_icon(icon_name);
                                            obj.icon_print_list.push(icon_name);
                                        }
                                    })
                                }
                            }
                        })
                }
                print_data.module_print_data.push(obj);
            })
        }
    })

    //    add_logo(backplate_code);

    //    init_global_svg(backplate_code);
    print_data["backplate"] = backplate_code;
}

// var mysql = require('mysql');

// var con = mysql.createConnection({
// host: "localhost",
// user: "myusername",
// password: "mypassword",
// database: "mydb"
// });

// con.connect(function(err) {
// if (err) throw err;
// console.log("Connected!");
// //Insert a record in the "customers" table:
// var sql = "INSERT INTO customers (name, address) VALUES ('Company Inc', 'Highway 37')";
// con.query(sql, function (err, result) {
// if (err) throw err;
// console.log("1 record inserted");
// });
// });

function download_svg_as_file() {


    if (!is_plate_selected)
        return alert("Please select top plate");

    let safe_copy = document.querySelector(".board-preview").outerHTML;
    create_svg();
    print_data["topplate"] = topplate;
    let txt = add_print_data(print_data);
    console.log("Resetting data");
    document.querySelector(".board-preview").outerHTML = safe_copy;

    let content = svg.outerHTML;
    // let filename = prompt("Enter board name");
    // console.log("Test");
    // console.log(content);

    // Send SVG data to server using AJAX //dev start
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "save_svg.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Server Response:", xhr.responseText);
        }
    };
    xhr.send("data=" + encodeURIComponent(content)); //dev end

    let blob = new Blob([content], { type: 'text/plain' });
    let url = URL.createObjectURL(blob);

    let blob2 = new Blob([txt], { type: 'text/plain' });
    let url2 = URL.createObjectURL(blob2);

    // let link = document.createElement('a');
    // link.href = url;
    // link.download = filename + ".svg";
    // link.innerHTML = 'Download File';
    // document.body.appendChild(link);
    // link.click();

    // let link2 = document.createElement('a');
    // link2.href = url2;
    // link2.download = filename + ".txt";
    // link2.innerHTML = 'Download File';
    // document.body.appendChild(link2);
    // link2.click();

    // link.remove();
    // link2.remove();

    container.container_count = 0;
}
