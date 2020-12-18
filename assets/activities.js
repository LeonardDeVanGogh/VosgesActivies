import './styles/activities.css';


/* filter section */
let filteredElements = document.getElementById('filterDashboard').getElementsByClassName('filter');
let activities = document.getElementsByClassName("activity");

for(i = 0; i < filteredElements.length;i++){
    filteredElements[i].addEventListener('click',updateFilter)
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
        if(activities[i].classList.contains('activityHidden')){
            activities[i].classList.remove('activityHidden');
            activities[i].classList.add('activityDisplayed');
        }
        let j;
        for(j=0;j<filteredElements.length;j++){
            if(filteredElements[j].classList.contains('selected')){
                if(!activities[i].classList.contains(filteredElements[j].dataset.filter)){
                    activities[i].classList.remove('activityDisplayed');
                    activities[i].classList.add('activityHidden');
                }
            }
        }
    }

}

/* map section */

//console.log(JSON.parse(data));

let data = document.querySelectorAll('[data-activities]');

let dataObject = Array.from(data).map(item => JSON.parse(item.dataset.activities));
console.log(dataObject[0].length);
let i;
for (i=0;i<dataObject[0].length;i++){
    let test = JSON.parse(dataObject[0][i]);
    console.log(test["id"]);
}


var mymap = L.map('mapid').setView([48.07230, 6.87282], 13);
L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
}).addTo(mymap);

