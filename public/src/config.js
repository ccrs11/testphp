export default {
    async phatname(path){
        
        let url = "http://localhost/ApolT01-009/testphp/"
        let name = new URL(path).pathname
        let peticion = await fetch(`${name.replace(".js", ".html")}`);
        let name_componet = name.split("/").pop().replace(".js", "")
        return [await peticion.text() , name_componet, name, url];   
    }
}
