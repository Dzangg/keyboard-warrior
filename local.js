let user={
    doneLessons:[],
    lessons:[],
    numLessons:0,
    load: function (){
        const localDoneLessons=localStorage.getItem('lessons');
        if(localDoneLessons){
            user.doneLessons=JSON.parse(localDoneLessons);
        }
        if(this.doneLessons.length===0){
            for(let i=0;i<this.numLessons;i++){
                const lesson=document.getElementById(`${lesson}+i`);
                let info=document.createElement('p');
                info.setAttribute('info','not done');
                lesson.appendChild(info);
            }
        }
        else{
            for(let i=0;i<this.numLessons;i++){
                const lesson=document.getElementById(`${lesson}+i`);
                if('ma Sprawdzac czy istnieje wystapienie lekcji'){
                    let info=document.createElement('p');
                    info.setAttribute('info','done');
                    lesson.appendChild(info);
                }
                else{
                    let info=document.createElement('p');
                    info.setAttribute('info','not done');
                    lesson.appendChild(info);
                }
            }
        }
    },
}