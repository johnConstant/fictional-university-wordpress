import $ from 'jquery';

class Search {
    // Decribe and create/initate our object
    constructor(){
        this.addSearchHTML();
        this.openBtn = $('.js-search-trigger');
        this.closeBtn = $('.search-overlay__close');
        this.searchOverlay = $('.search-overlay');
        this.isOverlayOpen = false;
        this.searchField = $('#search-term');
        this.results = $('#search-overlay__results');
        this.isSpinnerVisible = false;
        this.prevValue;

        this.events();
        this.timer;
    }

    // Events
    events(){
        this.openBtn.on('click', this.openOverlay.bind(this));
        this.closeBtn.on('click', this.closeOverlay.bind(this));
        $(document).on('keydown', this.keyPressDispatcher.bind(this));
        this.searchField.on('keyup', this.typingLogic.bind(this));
        
    }

    // Methods
    openOverlay(){
        this.searchOverlay.addClass("search-overlay--active");
        $('body').addClass('body-no-scroll');
        setTimeout(() => this.searchField.focus(), 301);
        this.isOverlayOpen = true;
        return false;
    }
    closeOverlay(){
        this.searchOverlay.removeClass('search-overlay--active');
        $('body').removeClass('body-no-scroll');
        this.isOverlayOpen = false;
        this.searchField.val('');
    }
    keyPressDispatcher(event){
        if(event.keyCode === 83 && !this.isOverlayOpen ){
            this.openOverlay();  
        } else if (event.keyCode === 27 && this.isOverlayOpen){
            this.closeOverlay(); 
        }
    }
    typingLogic(){
        if(this.searchField.val() !== this.prevValue){
            clearTimeout(this.timer);
            // If search field is empty run this code
            if(this.searchField.val()){
                if(!this.isSpinnerVisible){
                    this.results.html('<div class = "spinner-loader"></div>');
                    this.isSpinnerVisible = true;
                }
                this.timer = setTimeout(this.getResults.bind(this), 500);
            }else{
                this.results.html("");
                this.isSpinnerVisible = false;
            }
        }
        this.prevValue = this.searchField.val();
    }
    getResults(){
        $.getJSON(universityData.root_url + '/wp-json/university/v1/search?term=' + this.searchField.val(),
        (searchResults) => {
            this.results.html(`
            <div class = "row">
                <div class = "one-third">
                    <h2 class = "search-overlay__section-title">General Information</h2>
                        ${searchResults.generalInfo.length ? '<ul class = "link-list min-list">' : `<p>No results found</p>`}
                        ${searchResults.generalInfo.map(result => `<li><a href = "${result.link}">${result.title}</a> 
                        ${result.type === 'post' ? `by ${result.authorName}` : ''}</li>`).join('')}
                        ${searchResults.generalInfo.length ? '</ul>' : ''}
                </div>
                <div class = "one-third">
                    <h2 class = "search-overlay__section-title">Programs</h2>
                        ${searchResults.programs.length ? '<ul class = "link-list min-list">' : `<p>No programs found</p><a href = '${universityData.root_url}/programs'>View all programs</a>`}
                        ${searchResults.programs.map(result => `<li><a href = "${result.link}">${result.title}</a></li>`).join('')}
                        ${searchResults.programs.length ? '</ul>' : ''}
                    <h2 class = "search-overlay__section-title">Professors</h2>
                        ${searchResults.professors.length ? '<ul class = "professor-cards">' : `<p>No professors found</p>`}
                        ${searchResults.professors.map(result => `<li class = 'professor-card__list-item'><a class = "professor-card" href = "${result.link}"><img src = "${result.image}" class = "professor-card__image"/>
                        <span class = "professor-card__name">${result.title}</span></a></li>`).join('')}
                        ${searchResults.professors.length ? '</ul>' : ''}
                </div>
                <div class = "one-third">
                    <h2 class = "search-overlay__section-title">Campuses</h2>
                        ${searchResults.campuses.length ? '<ul class = "link-list min-list">' : `<p>No results found</p><a href = '${universityData.root_url}/campuses'>View all campuses</a>`}
                        ${searchResults.campuses.map(result => `<li><a href = "${result.link}">${result.title}</a></li>`).join('')}
                        ${searchResults.campuses.length ? '</ul>' : ''}
                    <h2 class = "search-overlay__section-title">Events</h2>
                        ${searchResults.events.length ? '' : `<p>No results found</p><a href = '${universityData.root_url}/events'>View all events</a>`}
                        ${searchResults.events.map(result => 
                        ` <div class="event-summary">
                        <a class="event-summary__date t-center" href="${result.link}">
                          <span class="event-summary__month">${result.month}</span>
                          <span class="event-summary__day">${result.day}</span>
                        </a>
                        <div class="event-summary__content">
                          <h5 class="event-summary__title headline headline--tiny"><a href="${result.link}">${result.title}</a></h5>
                          <p>${result.excerpt} <a href="${result.link}" class="nu gray">Learn more</a></p>
                        </div>
                      </div>`).join('')}
                      `)
                    

            this.isSpinnerVisible = false
        })
        
        // $.when(
        //     $.getJSON(universityData.root_url + '/wp-json/university/v1/posts?term=' + this.searchField.val()),
        //     $.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val())
        // )
        // .then((posts, pages) => {
        //     console.log(posts , pages)
        //     const combinedResults = posts[0].concat(pages[0]);
        //     this.results.html(`
        //     <h2 class = "search-overlay__section-title">Search Results</h2>
        //     ${combinedResults.length ? '<ul class = "link-list min-list">' : '<p>No results found</p>'}
        //     ${combinedResults.map(result => `<li><a href = "${result.link}">${result.title.rendered}</a> 
        //     ${result.type === 'post' ? `by ${result.authorName}` : ''}</li>`).join('')}
        //     ${combinedResults.length ? '</ul>' : ''}
        //     `);
        //     this.isSpinnerVisible = false;
        // }, () => {
        //     this.results.html("<p>Unexpected error, please try again</p>" );
        // })
    }

    addSearchHTML(){
        $('body').append(`
        <div class = "search-overlay">
            <div class = "search-overlay__top">
                <div class = "container">
                    <i class = "fa fa-search search-overlay__icon" aria-hidden = "true"></i>
                    <input type = "text" class = "search-term" placeholder="What are you looking for?" id = "search-term" autocomplete="off" />
                    <i class = "fa fa-window-close search-overlay__close" aria-hidden = "true"></i>
                </div>
            </div>
            <div class="container">
                <div id="search-overlay__results"></div>
            </div>
        </div>
    `);
    }
};



export default Search;
