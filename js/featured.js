function gtolb(g){
    return g*0.0022046;
}
function formatPhoneNumber(phoneNumberString) {
    let cleaned = ('' + phoneNumberString).replace(/\D/g, '')
    let match = cleaned.match(/^(1|)?(\d{3})(\d{3})(\d{4})$/)
    if (match) {
        let intlCode = (match[1] ? '+1 ' : '')
        return [intlCode, '(', match[2], ') ', match[3], '-', match[4]].join('')
    }
    return phoneNumberString
}
function motoyr(mo) {
    if(mo >= 12) {
        return (mo / 12).toFixed(1) + " years";
    } else {
        return mo + " months";
    }
}
function create_post_text(innerText, parent) {
    let text = document.createElement("span");
    text.className="post-text";
    text.innerText=innerText;
    parent.appendChild(text);
    parent.appendChild(document.createElement("br"));
    return text;
}
function callback() {
    const resp = JSON.parse(this.response);
    if(resp["success"]) {
        let loadmore = document.getElementById("more");
        if(loadmore) {
            loadmore.remove();
        }
        for (const index in resp["posts"]) {
            const postInfo = resp["posts"][index];
            let container = document.createElement("div");
            container.className = "featured-container";
            let post_card = document.createElement("div");
            post_card.className = "post-card";
            container.appendChild(post_card);
            let h4 = document.createElement("h4");
            h4.innerText = postInfo["animal_name"];
            h4.className = "animal-name";
            post_card.appendChild(h4);
            let img = document.createElement("img");
            img.className = "post-img";
            img.src = "images/animals/post" + postInfo["animal_id"] + "-fitted.png";
            post_card.appendChild(img);
            let panel = document.createElement("div");
            panel.className = "animal-info-panel";
            post_card.appendChild(panel);

            create_post_text("Species: " + postInfo["species"], panel);
            create_post_text("Breed: " + postInfo["breed"], panel);
            create_post_text("Age: " + motoyr(postInfo["age"]), panel);
            create_post_text("Gender: " + postInfo["gender"], panel);
            create_post_text("Weight: " + gtolb(parseInt(postInfo["weight"])).toFixed(1) + "lb", panel);
            create_post_text("Posted: " + postInfo["post_created"], panel);
            create_post_text("", panel); // lazy line break
            let opanel = document.createElement("div");
            opanel.className="owner-info-panel";
            create_post_text("Owner: " + postInfo["poster_name"], opanel);
            create_post_text("Location: " + postInfo["city"] + ", " + postInfo["state"], opanel);
            create_post_text("Phone Number: " + formatPhoneNumber(postInfo["phone"]), opanel);
            post_card.appendChild(opanel);

            document.body.appendChild(container);
        }

        if(resp["posts"].length == 5){
            let more = document.createElement("button");
            more.className = "button";
            more.id = "more";
            more.onclick = () => getFeatured(featuredIndex++);
            more.innerText = "Load More";
            document.body.appendChild(more);
        }
    } else {
        alert("Error loading posts: " + resp["message"]);
    }
}
let featuredIndex = 0;
function getFeatured(index){
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "api/get_featured.php?i=" + index);
    xhr.addEventListener("load", callback);
    xhr.send();
}

getFeatured(featuredIndex++);