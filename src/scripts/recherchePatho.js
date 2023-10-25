async function getSymptoms(element) {
    let json = await fetch("/api/symptoms?pathology=" + element.name)
        .then(function(response) {
            return response.json();
        })
        .catch(function(err) {
            console.log('Failed to fetch page: ', err);
        });

        replaceSymptoms(json, element.name);
}

function replaceSymptoms(symptoms, pathologyName) {
    let pathologyNameElem = document.getElementById("pathologyName");
    let symptomsElem = document.getElementById("symptoms");
    pathologyNameElem.innerHTML = pathologyName;
    symptomsElem.innerHTML = "";

    for (let symptom of symptoms) {
        symptomsElem.innerHTML += "<li>" + symptom.desc + "</li>";
    }
}