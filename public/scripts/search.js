const search = document.querySelector('input[placeholder="Search posts..."]');
const forumElements = document.querySelector(".forum-elements");

search.addEventListener("keyup", function(event) {
    event.preventDefault();

    const data = { search: this.value };

    fetch("/search", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    }).then(function(response) {
        return response.json();
    }).then(function(posts) {
        forumElements.innerHTML = "";
        loadPosts(posts);
    }); 
});

function loadPosts(posts) {
    posts.forEach(post => {
        console.log(post);
        createPost(post);
    });
}

function createPost(post) {
    const template = document.querySelector("#post-template");

    const clone = template.content.cloneNode(true);

    const status = clone.querySelector(".status-element");
    let statusImagePath;
    let statusColor;

    switch (post.status) {
        case 'pinned':
            statusImagePath = "../../public/images/status_images/status1.svg";
            statusColor = "#FF833E";
            break;
        case 'resolved':
            statusImagePath = "../../public/images/status_images/status2.svg";
            statusColor = "#6EBE45";
            break;
        case 'open':
            statusImagePath = "../../public/images/status_images/status3.svg";
            statusColor = "#C0C0C0";
            break;
    }

    status.style.backgroundImage = `url(${statusImagePath})`;
    status.style.backgroundColor = statusColor;

    const title = clone.querySelector(".forum-text");
    title.textContent = post.title;

    const replies = clone.querySelector(".forum-replies");
    replies.textContent = post.replies;

    const views = clone.querySelector(".forum-views");
    views.textContent = post.views;

    const postedBy = clone.querySelector(".posted-by-element");
    const imagePath = "./public/images/user_profiles/" + post.profile_image_path;
    postedBy.style.backgroundImage = `url(${imagePath})`;

    const date = clone.querySelector(".forum-date");
    const formattedDate = new Date(post.post_created_at).toISOString().split('T')[0];
    date.textContent = formattedDate;

    forumElements.appendChild(clone);
}