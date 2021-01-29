import './styles/activities.css';

let i;

/* map section */

var mymap = L.map('mapid').setView([48.07220, 6.87284], 13);
L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
}).addTo(mymap);



let request = new XMLHttpRequest();
let formData = new FormData();
formData.append("filterSelected", "false");
request.open('POST', '/api/activitiesToJson');
request.addEventListener('load', function () {
    let activitiesJson = JSON.parse(request.response);
    for(i=0;i<activitiesJson.length;i++){
        let isHandicaped = activitiesJson[i].isHandicaped===true?'<i class="fas fa-wheelchair fa-2x"></i>':'';
        let animals = activitiesJson[i].isAnimalsFriendly===true?'<i class="fas fa-paw fa-2x"></i>':'';
        let indoor = activitiesJson[i].isIndoor===true?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
        let outdoor = activitiesJson[i].isOutdoor===true?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
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
                '</p>' +
                '<span title="Accessible aux personnes à mobilité réduite">' + isHandicaped + '</span>' +
                '<span title="animaux acceptés">' + animals + '</span></p>' +
                '<p>' +
                '<a class="btn btn-transparent" title="voir l\'activité" href="/activity/read/' + activitiesJson[i].id + '">' +
                '<i class="fas fa-info"></i>' +
                '<span> détails</span>' +
                '</a>' +
                '</p>'
            )
    }
});

request.send(formData);

/*mymap.eachLayer((layer) => {
    layer.remove();
});
L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
}).addTo(mymap);*/

/* filter section */
let filteredElements = document.getElementById('filterDashboard').getElementsByClassName('filter');
let activities = document.getElementsByClassName("activity");
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

    /*
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
    }*/
    mymap.eachLayer((layer) => {
        layer.remove();
    });
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
    }).addTo(mymap);
    formData.delete("filterSelected");
    let j
    for(j=0;j<filteredElements.length;j++){
        filteredElements[j].classList.contains('selected')?formData.append(filteredElements[j].dataset.filter, 1):formData.append(filteredElements[j].dataset.filter, 0);
    }
    let request = new XMLHttpRequest();


    request.open('POST', '/api/activitiesToJson');
    request.addEventListener('load', function () {
        let activitiesJson = JSON.parse(request.response);

        for(i=0;i<activitiesJson.length;i++){

            let isHandicaped = activitiesJson[i].isHandicaped===true?'<i class="fas fa-wheelchair fa-2x"></i>':'';
            let animals = activitiesJson[i].isAnimalsFriendly===true?'<i class="fas fa-paw fa-2x"></i>':'';
            let indoor = activitiesJson[i].isIndoor===true?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
            let outdoor = activitiesJson[i].isOutdoor===true?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
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
                    '</p>' +
                    '<span title="Accessible aux personnes à mobilité réduite">' + isHandicaped + '</span>' +
                    '<span title="animaux acceptés">' + animals + '</span></p>' +
                    '<p>' +
                    '<a class="btn btn-transparent" title="voir l\'activité" href="/activity/read/' + activitiesJson[i].id + '">' +
                    '<i class="fas fa-info"></i>' +
                    '<span> détails</span>' +
                    '</a>' +
                    '</p>'
                )
        }
    });
    request.send(formData);
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




