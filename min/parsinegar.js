
requirejs.config({
    baseUrl: "http://localhost/assets/js/",
    paths: {
		teacher: "teacher"
    }
});




require(["teacher"],function(){
//Loaded...
});
