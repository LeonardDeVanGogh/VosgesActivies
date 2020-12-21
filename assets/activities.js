import './styles/activities.css';
/* map section */
let activitiesJson = JSON.parse(data);
console.log(activitiesJson);

var mymap = L.map('mapid').setView([48.07220, 6.87284], 13);
L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
}).addTo(mymap);


for(i=0;i<activitiesJson.length;i++){
    let isHandicaped = activitiesJson[i].is_handicaped===true?'<i class="fas fa-wheelchair fa-2x"></i>':'';
    let animals = activitiesJson[i].animals===true?'<i class="fas fa-paw fa-2x"></i>':'';
    let indoor = activitiesJson[i].is_indoor===true?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
    let outdoor = activitiesJson[i].animals===true?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
    let marker = new L.marker([activitiesJson[i].latitude,activitiesJson[i].longitude], {
        title: activitiesJson[i].name,

    }).addTo(mymap)
        .bindPopup('<h6>' + activitiesJson[i].name + '</h6>' +
                    '</p>' +
                        '<span> Intérieur : </span>' +
                        '<span> ' + indoor + '</span>' +
                        '<span>     Extérieur : </span>' +
                        '<span>' + outdoor + '</span>' +
                    '</p>' +
                    '</p>' + isHandicaped + animals + '</p>' +
                    '<p>' +
                        '<a class="btn btn-transparent" href="/activity/read/' + activitiesJson[i].id + '">' +
                            '<i class="fas fa-info"></i>' +
                            '<span> détails</span>' +
                        '</a>' +
                    '</p>'
        )
}

/* filter section */
let filteredElements = document.getElementById('filterDashboard').getElementsByClassName('filter');
let activities = document.getElementsByClassName("activity");
let i;
for(i = 0; i < filteredElements.length;i++){
    filteredElements[i].addEventListener('click',updateFilter);
}

function updateFilter(){
    if (this.classList.contains('selected')){
        this.classList.remove("selected");
        this.classList.add("unselected");
    }
    else{
        this.classList.remove("unselected");
        this.classList.add("selected");
    }
    for(i=0;i<activities.length;i++){
        if(activities[i].classList.contains('hidden')){
            activities[i].classList.remove('hidden');
            activities[i].classList.add('displayed');
        }
        let j;
        for(j=0;j<filteredElements.length;j++){
            if(filteredElements[j].classList.contains('selected')){
                if(!activities[i].classList.contains(filteredElements[j].dataset.filter)){
                    activities[i].classList.remove('displayed');
                    activities[i].classList.add('hidden');
                }
            }
        }
    }
}

/* switch list/map rendering */


let viewsOptions = document.getElementsByClassName("viewsOptions");
for(i = 0; i < viewsOptions.length;i++){
    console.log(viewsOptions);
    viewsOptions[i].addEventListener('click',updateView);
}


function updateView(){
    let views = document.getElementsByClassName("activitiesViews");
    for(i=0;i<views.length;i++){
        views[i].classList.remove('displayed');
        views[i].classList.add('hidden');
    }
    if(this.classList.contains('isList')){
        document.getElementById('isList').classList.remove('hidden');
        document.getElementById('isList').classList.add('displayed');

    }else{
        document.getElementById('mapid').classList.remove('hidden');
        document.getElementById('mapid').classList.add('displayed');
    }
}


