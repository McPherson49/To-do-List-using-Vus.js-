let webPage = window.location.pathname.split('/');
let page = webPage[webPage.length - 1];

let newApp = Vue.createApp({
    data(){
        return{
            name : '',
            time : ''

        }              
    },
    methods: {
        async handReturn(){
            const fetchall = {
                name: this.name,
                time: this.time
                
            }
            let response = await axios.post('http://localhost/todo_list/addlistlogic.php', fetchall)
            if(response.data.status){
                alert ("List Created")
                window.location.href = './index.php'
            }
        }
    }
});

newApp.mount("#app");
