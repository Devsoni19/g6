const delta_x = 22.5;
svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');

let fan_icon_container = "<g><path stroke=\"blue\" fill=\"none\" d=\"M0 0 L30 0 L30 30 L0 30 Z\"></path></g>"

let icon_container = "<g><path stroke=\"blue\" fill=\"none\" d=\"M0 0 L11 0 L11 11 L0 11 Z\"></path></g>"

let ir_svg = '<g><path d="M 3.5017 1.7494 c 0.441 0 0.7992 0.3582 0.7992 0.7992 c 0 0.441 -0.3582 0.7992 -0.7992 0.7992 c -0.441 0 -0.7992 -0.3582 -0.7992 -0.7992 c 0 -0.441 0.3582 -0.7992 0.7992 -0.7992 z M 0.2782 2.6492 l 2.2289 0 c 0.0148 0.1391 0.0562 0.2723 0.1214 0.3878 l -0.8969 0.6275 l -1.4534 -1.0182 z M 0.219 4.7242 c -0.1391 -0.1717 -0.219 -0.3878 -0.219 -0.6246 l 0 -1.4001 l 1.557 1.0893 l -1.335 0.9354 z M 1.9062 3.7888 l 0.8377 -0.5861 c 0.1628 0.1894 0.3966 0.3167 0.6571 0.3434 l 0 1.2906 l -1.4948 -1.0478 z M 3.401 5.1001 l -2.4006 0 c -0.2427 0 -0.4647 -0.0858 -0.6364 -0.2309 l 1.3675 -0.959 l 1.6694 1.1692 l 0 0.0207 z M 3.5994 4.8366 l 0 -1.2906 c 0.2634 -0.0266 0.4943 -0.1539 0.6571 -0.3434 l 0.8377 0.5861 l -1.4948 1.0478 z M 6.6393 4.8692 c -0.1746 0.145 -0.3966 0.2309 -0.6364 0.2309 l -2.4006 0 l 0 -0.0207 l 1.6694 -1.1692 l 1.3675 0.959 z M 5.2718 3.6674 l -0.8969 -0.6275 c 0.0651 -0.1184 0.1095 -0.2486 0.1214 -0.3878 l 2.2289 0 l -1.4534 1.0182 z M 7.0004 2.6995 l 0 1.4001 c 0 0.2368 -0.0829 0.4529 -0.219 0.6246 l -1.335 -0.9354 l 1.557 -1.0893 z M 6.7251 2.4509 l -2.2289 0 c -0.0148 -0.1391 -0.0562 -0.2723 -0.1214 -0.3878 l 0.8969 -0.6275 l 1.4534 1.0182 z M 6.7814 0.3759 c 0.1391 0.1717 0.219 0.3878 0.219 0.6246 l 0 1.4001 l -1.557 -1.0893 l 1.335 -0.9354 z M 5.0971 1.3113 l -0.8377 0.5861 c -0.1628 -0.1894 -0.3966 -0.3167 -0.6571 -0.3434 l 0 -1.2906 l 1.4948 1.0478 z M 3.5994 0 l 2.4006 0 c 0.2427 0 0.4647 0.0858 0.6364 0.2309 l -1.3675 0.959 l -1.6694 -1.1692 l 0 -0.0207 z M 0 2.4006 l 0 -1.4001 c 0 -0.2368 0.0829 -0.4529 0.219 -0.6246 l 1.335 0.9354 l -1.557 1.0893 z M 2.5042 2.4509 l -2.2289 0 l 1.4534 -1.0182 l 0.8969 0.6275 c -0.0651 0.1184 -0.1095 0.2486 -0.1214 0.3878 z M 3.401 0.2634 l 0 1.2906 c -0.2634 0.0266 -0.4943 0.1539 -0.6571 0.3434 l -0.8377 -0.5861 l 1.4948 -1.0478 z M 1.0005 0 l 2.4006 0 l 0 0.0207 l -1.6694 1.1692 l -1.3675 -0.959 c 0.1746 -0.145 0.3966 -0.2309 0.6364 -0.2309 z"/></g>';

let logo_svg = `<svg><path xmlns="http://www.w3.org/2000/svg" d="M40 70l0.12 -23.98 13.1 -8.79 25.07 9.58 0.07 5.4 -12.77 7.91 0 -4.34 -20.14 -7.51 -0.22 17.25 20.65 8.2 7.67 -5.27c0,-1.38 0,-2.76 0,-4.14l-7.73 5.06 -15.48 -6.1 0 -6.04 15.54 6.28 12.97 -8.91c-0.07,5.56 -0.17,11.07 -0.25,16.62l-12.91 8.83 -25.69 -10.06z" transform="scale(0.8)" fill="#888"></path></svg>`

let backplate_data = {
    "2M": {width:"85.1764mm", height:"83.6764mm", left: "24mm", top: "23mm"},
    "3M": {width:"107.976mm", height:"83.6764mm", left: "24.25mm", top: "23mm"},
    "4M": {width:"147.176mm", height:"83.6764mm", left: "33mm", top: "23mm"},
    "6M": {width:"220.176mm", height:"83.6764mm", left: "46.5mm", top: "23mm"},
    "8M": {width:"241.176mm", height:"83.4263mm", left: "34.5mm", top: "23mm"},
    "8MV": {width:"147.176mm", height:"154.176mm", left: "33mm", top: "25.25mm", top2: "89.75mm"},
    "12M": {width:"220.176mm", height:"154.176mm", left: "46.5mm", top: "25.25mm", top2: "89.75mm"},
    "16M": {width:"241.176mm", height:"154.176mm", left: "34.5mm", top: "26.5mm", top2: "88.5mm"},
    "18M": {width:"219.176mm", height:"212.176mm", left: "46.5mm", top: "35.5mm", top2: "100mm", top3: "164.5mm"}
}

function extractNumericValue(measurement) {
    return parseFloat(measurement.replace(/[^\d.]/g, ''));
}

function get_svg_item(src){
    let g = document.createElementNS('http://www.w3.org/2000/svg', 'g');
    g.innerHTML = src;
    return g.childNodes[0];
}

function add_baseplate_frame(src){
		console.log("add_baseplate_frame");
        let frame = get_svg_item(baseplate_frame_data[src]);
		svg = frame;
	}

function add_logo(backplate){
    let logo = get_svg_item(logo_svg);

    logo.setAttribute("x", extractNumericValue(backplate_data[backplate].width) - 35 + "mm");
    logo.setAttribute("y", extractNumericValue(backplate_data[backplate].height) - 25 + "mm");

    svg.appendChild(logo);
}

class container{
    static container_count = 0;

    constructor(backplate){
        // console.log("Passed backplate=" + backplate);
        this.num_of_icons = 0;
        this.base_x = extractNumericValue(backplate_data[backplate].left);

        if(container.container_count == 0){
            this.base_y = extractNumericValue(backplate_data[backplate].top);
        }else if(container.container_count == 1){
            console.log("Second condition");
            this.base_y = extractNumericValue(backplate_data[backplate].top2);
        }else{
            console.log("Third condition");
            this.base_y = extractNumericValue(backplate_data[backplate].top3);
        }

        container.container_count++;

        switch (backplate) {
            case "2M":
                this.capacity = 2;
                break;

            case "3M":
                this.capacity = 3;
                break;

            case "16M":
            case "8M":
                this.capacity = 8;
                break;

            case "4M":
                this.capacity = 4;
                break;

            case "8MV":
                this.capacity = 4;
                break;
        
            default:
                this.capacity = 6;
        }
    }
	
	add_board_frame(src){
		console.log("add_board_frame(src) " + src);
		let g = get_svg_item(board_frame_data[src]);
		g.setAttribute("transform","translate(" + (this.base_x + (this.num_of_icons * delta_x)) + " " + this.base_y + ")");
		svg.appendChild(g);
		console.log("check")
	}
	
    add_icon(src){
        if(this.num_of_icons == this.capacity){
            console.log("Container full");
            return -1;
        }
		
		let g = get_svg_item(icon_data[src]);
		g.setAttribute("transform","translate(" + (this.base_x + (this.num_of_icons * delta_x) + 5.75) + " " + (this.base_y+17) + ")");
		svg.appendChild(g);
		
        this.num_of_icons++;
    }

    add_1_icon(src){
        if(this.num_of_icons == this.capacity){
            console.log("Container full");
            return -1;
        }
		
		let g = get_svg_item(icon_data[src]);
		g.setAttribute("transform","translate(" + (this.base_x + (this.num_of_icons * delta_x) + 11.25) + " " + (this.base_y+11.25) + ")");
		svg.appendChild(g);
		
        this.num_of_icons=this.num_of_icons+2;
    }

    add_2_icon(src1, src2){
        if(this.num_of_icons == this.capacity){
            console.log("Container full");
            return -1;
        }

		let g = get_svg_item(icon_data[src1]);
		g.setAttribute("transform","translate(" + (this.base_x + (this.num_of_icons * delta_x) + 5.75) + " " + (this.base_y+5.75) + ")");
		svg.appendChild(g);

		g = get_svg_item(icon_data[src2]);
		g.setAttribute("transform","translate(" + (this.base_x + (this.num_of_icons * delta_x) + 5.75) + " " + (this.base_y+28.25) + ")");
		svg.appendChild(g);

        this.num_of_icons++;
    }

    add_fan(src){
        if(this.num_of_icons == this.capacity){
            console.log("Container full");
            return -1;
        }
		console.log(src);
		let g = get_svg_item(icon_data[src]);
		g.setAttribute("transform","translate(" + (this.base_x + (this.num_of_icons * delta_x) + 7.5) + " " + (this.base_y+7.5) + ")");
		svg.appendChild(g);

        this.num_of_icons += 2;
    }

    add_component(src){
        if(this.num_of_icons == this.capacity){
            console.log("Container full: ");
            console.log(this);
            return -1;
        }
		
		let g = get_svg_item(component_data[src]);
		g.setAttribute("transform","translate(" + (this.base_x + (this.num_of_icons * delta_x)) + " " + (this.base_y) + ")");
		svg.appendChild(g);
        
        if(src == "6A Plug" || src == "16A Plug" || src == "13A Plug"){
			this.add_board_frame("Ssw2");
            this.num_of_icons += 2;
            console.log("incremented by 2");

        }
        else{
            console.log("incremented by 1");
			this.add_board_frame("Ssw1");
            this.num_of_icons += 1;
        }
		
    }

    add_ir_window(comp){
        let ir_window = get_svg_item(ir_svg);
        console.log("Adding IR window for " + comp);
        console.log("Base x = " + this.base_x);

        let ir_x;

        switch(comp){
            // 45mm / 2 = 22.5 - 3 = 19.5
            // 90mm / 2 = 45 - 3 = 42
            // 135mm / 2 = 67.5 - 3 = 64.5 
            case "Ssw2": ir_x = 22.5-3.5; break;
            case "Ssw4": ir_x = 45-3.5; break;
            case "Ssw6": ir_x = 67.5-3.5; break;
        }
		console.log("translate(" + (this.base_x + (this.num_of_icons * delta_x) + ir_x) + " " + (this.base_y+37.75) + ")");
		ir_window.setAttribute("transform","translate(" + (this.base_x + (this.num_of_icons * delta_x) + ir_x) + " " + (this.base_y+35.2) + ")");
//        ir_window.setAttribute("x", this.base_x + (this.num_of_icons * delta_x) + ir_x + "mm");
//        ir_window.setAttribute("y", this.base_y + 40 + "mm");

        svg.appendChild(ir_window);
    }

    is_container_full(){
        if(this.num_of_icons == this.capacity) return true;
        else return false;
    }
}

function add_print_data(data){
    let string = "G6 Board Data";

    string += "\n\nBackplate = " + data["backplate"] + "\n";
    string += "Topplate = " + data["topplate"] + "\n";

    data.module_print_data.forEach(module => {
        string += "\nModule Name = " + module.component_name + "\n";
        if(module.component_name == "other-component"){
            string += "Other Component = " + module.comp_print_list[0] + "\n";
        }else{
            module.icon_print_list.forEach(icon => {
                string += "Icon = " + icon + "\n";
            })
        }
    })

    return string;
}

function init_global_svg(backplate){
    svg.setAttribute("height", backplate_data[backplate].height);
    svg.setAttribute("width", backplate_data[backplate].width);

    place_top_plate_svg();
}

function place_top_plate_svg(){
    switch(topplate){
        case "black":
            src = "Black.png"; break;
        case "matte-black":
            src = "Matte_black.png"; break;
        case "white":
            src= "White.png"; break;
        case "own-bg":
            src = "Own_Background.png"; break;
        case "own-material":
            src = "Own_Material.png"; break;
    }

    let top_plate_image = document.createElementNS('http://www.w3.org/2000/svg', 'image');
    top_plate_image.setAttribute("href", "topplate/" + src);
    top_plate_image.setAttribute("height", "100%");
    top_plate_image.setAttribute("width", "100%");
    top_plate_image.setAttribute("preserveAspectRatio", "none");

    svg.insertBefore(top_plate_image, svg.childNodes[0]);
}