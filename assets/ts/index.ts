"use strict";

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("#cat, select").forEach((element) => {
        element.classList.add("form-control");
    });

    const calendar = document.querySelector("#wp-calendar");

    if (calendar) {
        calendar.classList.add("table", "table-hover");
    }

    document.querySelectorAll("td a").forEach((element) => {
        element.classList.add("badge");
        (element as HTMLElement).style.marginRight = "-10px";
    });
});
