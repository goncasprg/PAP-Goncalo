document.addEventListener("DOMContentLoaded", function () {
    fetch("api/get_cars.php")
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById("cards-container");
            container.innerHTML = "";

            data.forEach(car => {
                const card = document.createElement("div");
                card.classList.add("card");

                card.innerHTML = `
                    <div class="card-img" style="background-image: url('${car.image_url}');"></div>
                    <div class="card-info">
                        <p class="text-title">${car.brand} ${car.model}</p>
                        <p class="text-body">${car.engine_capacity}L ${car.fuel_type}</p>

                        <div class="car-details">
                            <span><i class="fas fa-calendar-alt"></i> ${car.registration_year}</span>
                            <span><i class="fas fa-road"></i> ${car.mileage} km</span>
                            <span><i class="fas fa-cogs"></i> ${car.transmission}</span>
                        </div>

                        <p class="price-text">Preço</p>
                        <p class="text-price">${car.price}€</p>
                    </div>
                    <button class="card-button">Saber mais</button>
                `;

                container.appendChild(card);
            });
        })
        .catch(error => console.error("Erro ao carregar os carros:", error));
});
