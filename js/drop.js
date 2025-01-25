const components = document.querySelectorAll(".component-selector .item");
const switches = document.querySelector(".switches");
const plugs = document.querySelector(".plugs");

components.forEach(element => {
    element.onclick = e => {
        add_component(e.target);
    }
});

function extract_switch_name(src){
    const first_of_ssw = src.indexOf("Ssw");
    const last_of_dot = src.lastIndexOf(".");
    return src.substring(first_of_ssw, last_of_dot);
}

function get_count(element){
    if(switches.contains(element)){
        src = extract_switch_name(element.src);
        let switches = src[3]/2;//parseInt(src[3]/2);
        return [switches, (src.includes('F') ? 1 : 0)];
    }
}

function get_width(element){
    if(switches.contains(element)){
        let count = get_count(element);
        if(element.src.includes("1x2"))
            count = [1,0];
        else if(element.src.includes("1"))
            count = [1,0];
        
        return count[0]*2 + count[1]*2;
    }
    else{
        if(plugs.contains(element)){
            if(element.src.includes("6A%202pin%20Plug.png")) 
				{	
				return 1;
				}
            else
			{
				return 2;
			}
        }else{
            return 1;
        }
    }
}

function get_delete_btn(){
    let btn = document.createElement("button");
    btn.className = "delete-btn";
    return btn;
}

function append_fan_holder(container){
    let fan_holder = document.createElement("div");
    fan_holder.className = "fan-holder";

    let fan_icon_holder = document.createElement("div");
    fan_icon_holder.className = "fan-icon-holder icon-holder";
    fan_icon_holder.onclick = holder_selected;

    fan_holder.appendChild(fan_icon_holder);
    fan_holder.setAttribute("data-size", 2);

    container.appendChild(fan_holder);
}

function append_switches(count, container, layout){
    for(let i = 0; i < count; i++){
        let switch_holder = document.createElement("div");
        switch_holder.className = "switch-holder";

        let switch_icon_holder = document.createElement("div");
        switch_icon_holder.className = "switch-icon-holder icon-holder";
        switch_icon_holder.onclick = holder_selected;

		let clonned_node = switch_icon_holder.cloneNode(true);
		clonned_node.onclick = holder_selected;
		
		if(layout == "1"){
			switch_holder.classList.add("one-holder");
            switch_holder.setAttribute("data-size", 2);
			switch_icon_holder.classList.add("bell");
		}
		else if(layout == "2x2"){
            switch_holder.classList.add("two-x-two-holder");
            let clonned_node_2 = clonned_node.cloneNode(true);
            clonned_node_2.onclick = holder_selected;

            let clonned_node_3 = clonned_node.cloneNode(true);
            clonned_node_3.onclick = holder_selected;

            switch_holder.appendChild(clonned_node_2);
            switch_holder.appendChild(clonned_node_3);
        }
        else if(layout == "1x2"){
            switch_holder.classList.add("one-x-two-holder");
            switch_holder.setAttribute("data-size", 2);

            let clonned_node_2 = clonned_node.cloneNode(true);
            clonned_node_2.onclick = holder_selected;

            switch_icon_holder.classList.add("up");
            clonned_node.classList.add("down");

            switch_holder.appendChild(clonned_node_2);
        }

        switch_holder.appendChild(switch_icon_holder);

		if (layout != "1"){
			switch_holder.appendChild(clonned_node);
        }
		container.appendChild(switch_holder);
    }
}

function append_other_component(element){
    let size = get_width(element);
    let other_component_holder = document.createElement("div");
    other_component_holder.className = "other-component-holder";
    
    if(size == 1){
        other_component_holder.style.aspectRatio = "1/2";
        other_component_holder.setAttribute("data-size", 1);
    }
    else if(size == 2){
        other_component_holder.style.aspectRatio = "1/1";
        other_component_holder.setAttribute("data-size", 2);
    }

    let delete_btn = get_delete_btn();
    delete_btn.onclick = e => {
        let container = e.target.parentElement.parentElement;
        let new_size = parseInt(container.getAttribute("data-avail")) + parseInt(e.target.parentElement.getAttribute("data-size"));
        container.setAttribute("data-avail", new_size);
        e.target.parentElement.remove();
    }
    other_component_holder.appendChild(delete_btn);

    other_component_holder.style.backgroundImage = "url(" + element.src + ")";
    if(element.src.includes("Blanking"))
        other_component_holder.style.opacity = "var(--blanking-plate-opacity)";
    other_component_holder.setAttribute("data-component-name", "other-component");
    current_container.appendChild(other_component_holder);
}



function add_component(element){
	if(element.classList.contains("title"))
			element = element.parentElement.childNodes[1].childNodes[1];
	
    if(element.className == "item"){
        element = element.childNodes[1].childNodes[1];
    }

    let current_container_index = 0;

    let required_size = get_width(element);
    let available_size = parseInt(all_containers[current_container_index].getAttribute("data-avail"));

    // Determining the proper container
    while(available_size < required_size){
        if(current_container_index == all_containers.length - 1){
            alert("Not enough space");
            return;
        }
        current_container_index++;
        available_size = parseInt(all_containers[current_container_index].getAttribute("data-avail"));
    }

    current_container = all_containers[current_container_index];
    current_container.setAttribute("data-avail", available_size - required_size);

    if(switches.contains(element)){
        let module_holder = document.createElement("div");
        module_holder.className = "module-holder";

        let component_count = get_count(element);

        if(component_count[1])
            append_fan_holder(module_holder);


        let switch_layout = "normal";
        if(element.src.includes("2x2")) switch_layout = "2x2";
        else if(element.src.includes("1x2")) switch_layout = "1x2";
        else if(element.src.includes("1")) switch_layout = "1";

        append_switches(component_count[0], module_holder, switch_layout);

        let delete_btn = get_delete_btn();

        delete_btn.onclick = e => {
            let container = e.target.parentElement.parentElement;
            let new_size = parseInt(container.getAttribute("data-avail")) + parseInt(e.target.parentElement.getAttribute("data-size"));
            container.setAttribute("data-avail", new_size);
            e.target.parentElement.remove();
        }
        
        module_holder.appendChild(delete_btn);
        
        let ir_img = document.createElement("img");
        ir_img.src = "img/IR.png";
        ir_img.className = "ir-img";
		
		if(switch_layout != "1"){
			module_holder.appendChild(ir_img);
		}

        module_holder.setAttribute("data-size", required_size);
        module_holder.setAttribute("data-component-name", extract_switch_name(element.src))

        current_container.appendChild(module_holder);
    }
    else{
        append_other_component(element);
    }

    if(all_slots_filled())
        next_section();
}