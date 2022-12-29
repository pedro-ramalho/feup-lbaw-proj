const optionSearchPosts = document.querySelector("#opt-search-posts");
const optionSearchUsers = document.querySelector("#opt-search-users");

const searchPosts = document.querySelector("#post-results");
const searchUsers = document.querySelector("#user-results");

const searchOpts = [optionSearchPosts, optionSearchUsers];
const searchContent = [searchPosts, searchUsers];

function showSingle(selected, opt) {
  for (const obj of searchContent) {
    if (obj != selected) {
      obj.style.display = "none";
    }
    else {
      obj.style.display = "flex";
    }
  }

  for (const obj of searchOpts) {
    if (obj != opt) {
      obj.style.fontWeight = "normal";
    }
    else {
      obj.style.fontWeight = "bold";
    }
  }
}

optionSearchPosts.addEventListener("click", showSingle.bind(this, searchPosts, optionSearchPosts));
optionSearchUsers.addEventListener("click", showSingle.bind(this, searchUsers, optionSearchUsers));