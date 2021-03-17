class seats
{
   Sseat='';
   trip;
   max_seats;
   Gseat;

  constructor(trip,max_seats,Gseat)
  {
    this.trip=trip;
    this.Gseat=Gseat;
    this.max_seats=max_seats;
  }

  getall()
  {
      if (this.Gseat.length==7) {
         set=new sevenseats(this.trip,this.max_seats,this.Gseat);
         return set.getall();
      }
      if (this.Gseat.length==11) {
         set=new elevenseats(this.trip,this.max_seats,this.Gseat);
         return set.getall();
      }
      if (this.Gseat.length==43) {
         set=new fortythreeseats(this.trip,this.max_seats,this.Gseat);
         return set.getall();
      }
  }

  checkavailablity(id)
  {
    const result = this.Gseat.find( ({ name }) => name == id );
    var existing = localStorage.getItem('seats_'+this.trip+'');
    existing = existing ? existing.split(',') : [];
    if (result && result.status) {
        status='booked';
    }
    else if(existing.find(element => element == id)) {
        status='seat selected';
    }
    else
    {
        status='seat available';
    }
    return status;
  }

  storeselected(el,id)
  {
    var existing = localStorage.getItem('seats_'+this.trip+'');
    if (! localStorage.getItem('trip')) {
       localStorage.setItem('trip',this.trip)
    }
    if (localStorage.getItem('trip')==this.trip)
    {
        existing = existing ? existing.split(',') : [];
        if (existing.find(element => element == id)) {
            var ind=existing.indexOf(id);
            existing.splice(ind, 1);
            $(el).toggleClass('selected available');
        }
        else{
           if (this.max_seats > existing.length) {
              existing.push(id);
              $(el).toggleClass('selected available');
           }
           else{
           alert('العدد الاقصي لحجز المقاعد'+this.max_seats+' وانت حجز  '+existing.length);
           }
        }
        localStorage.setItem('seats_'+this.trip+'', existing.toString());
    }
    else
    {
        if (confirm('للحجز سيتم حذف المقاعد الرحلة الأخري ؟')) {
            localStorage.clear();
        }
    }
  }
   addcard() {
    if (localStorage.getItem('trip')==this.trip && localStorage.getItem('seats_'+this.trip+'').split(',').length != 0 && localStorage.getItem('seats_'+this.trip+'').split(',')[0] != "") {
       return this.Sseat+='<hr class="my-4"><a class="bookingnow my-3" data-id="'+this.trip+'">احجز الان</a>';
     }
  }

}

class sevenseats extends seats
{
   rows=3;
   columns=3;

   getall()
   {
    this.Sseat='';
    var g=1;
     for (let i =1 ; i <=this.rows; i++) {
        this.Sseat+='<ul class="inline-block">';
        for (let j =1; j <=this.columns; j++) {
            if(i==1 && j==1){
                this.Sseat+='<li class="driver"><img src="/assets/img/vehicle-steering-wheel.svg" class="img-hor-vert" width="20px"></li>';
            }
            else if(i==1 && j==2){
                this.Sseat+='<li class="p-5 m-2 mt-3"></li>';
            }
            else{
                status=this.checkavailablity(g);
                this.Sseat+='<li class="'+status+'" data-id="'+g+'"><span class="numberseat">'+g+'</span><img src="/assets/img/seat.svg" class="img-hor-vert" width="20px"></li>';
                g++;
            }
        }
        this.Sseat+='</ul>';
     }
    this.addcard();
    return this.Sseat;
   }
}

class elevenseats extends seats
{
   rows=4;
   columns=3;

   getall()
   {
    this.Sseat='';
    var g=1;
     for (let i =1 ; i <=this.rows; i++) {
        this.Sseat+='<ul class="inline-block">';
        for (let j =1; j <=this.columns; j++) {
            if(i==1 && j==1){
                this.Sseat+='<li class="driver"><img src="/assets/img/vehicle-steering-wheel.svg" class="img-hor-vert" width="20px"></li>';
            }
            else{
                status=this.checkavailablity(g);
                this.Sseat+='<li class="'+status+'" data-id="'+g+'"><span class="numberseat">'+g+'</span><img src="/assets/img/seat.svg" class="img-hor-vert" width="20px"></li>';
                g++;
            }
        }
        this.Sseat+='</ul>';
     }
     this.addcard();
    return this.Sseat;
   }
}

class fortythreeseats extends seats
{
   rows=11;
   columns=5;

  getall()
  {
    this.Sseat='';
    var g=1;
     for (let i =1 ; i <=this.rows; i++) {
        this.Sseat+='<ul class="inline-block">';
        for (let j =1; j <=this.columns; j++) {
            if(i==1 && j==1){
                this.Sseat+='<li class="driver"><img src="/assets/img/vehicle-steering-wheel.svg" class="img-hor-vert h-20" width="20px"></li>';
            }
            else if(i==1 && j==2){
                this.Sseat+='';
            }
            else if(i!=11 && j==3){
                this.Sseat+='<li class="p-5 m-2 mt-3"></li>';
            }
            else{
                status=this.checkavailablity(g);
                this.Sseat+='<li class="'+status+'" data-id="'+g+'"><span class="numberseat">'+g+'</span><img src="/assets/img/seat.svg" class="img-hor-vert" width="20px"></li>';
                g++;
            }
        }
        this.Sseat+='</ul>';
     }
    this.addcard();
    return this.Sseat;
  }
}
