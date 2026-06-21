(function () {
    'use strict';

    document.addEventListener('click', function (event) {
        var house = event.target.closest('[data-af-frame-menu] .af-frame-menu__house');
        var openHouses = document.querySelectorAll('[data-af-frame-menu] .af-frame-menu__house.is-open');

        openHouses.forEach(function (openHouse) {
            if (openHouse !== house) {
                openHouse.classList.remove('is-open');
            }
        });

        if (house && window.matchMedia('(hover: none)').matches) {
            house.classList.toggle('is-open');
        }
    });
}());
