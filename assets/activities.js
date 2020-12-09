import './styles/activities.css';
console.log(data);

let filteredElements = document.getElementById('filterDashboard').getElementsByClassName('filter');
let activities = document.getElementsByClassName("activity");
let i;
for(i = 0; i < filteredElements.length;i++){
    filteredElements[i].addEventListener('click',updateFilter)
    console.log(filteredElements[i]);
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