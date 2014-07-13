/*
  Syntax is the following:
  new CrossFader('id1', 'id2', 'id3', 'id4);
  Where id1, id2, etc are ids of elements with children elements that have a class name of "text" and "image"
  where image will show first, then text overlays.
  Default container is #crossfade
  * 
*/
var CrossFader = Class.create();

CrossFader.prototype = {
  // settings
  interval: 5, // interval for changing crossfader (in seconds)
  items: [],
  currentItemIndex: 0,
  currentItem:null,
  timer: null,
  
  
  initialize: function(){
    this.container = $('crossfade');
    this.container.style.visibility = 'visible';
    
    for (var i=0, arg; arg = arguments[i]; i++)
    {
      if($(arg)=='' || $(arg)==null)
      	 continue;
      	 
      var item = $(arg);
      this.container.appendChild(item.remove());
      this.items.push({
        image: item.down('.image').hide(),
        text: item.down('.text').hide()
      });
    }
    
    // on init, show first one
    this.reveal(this.items[0]);
    
    // then set up an interval
    setInterval(this.poll.bind(this), this.interval*1000);
  },
  
  // timer function
  poll: function(){
    // reset to beginning if at end
    if (++this.currentItemIndex >= this.items.length) this.currentItemIndex = 0;
    this.reveal(this.items[this.currentItemIndex]);
  },
  
  reveal: function(item){
    // before revealing, we must hide if applicable
    if (this.currentItem){ this.hide(item); return }
    
    var show_text = function(){ 
      new Effect.Appear(item.text);
    }
    item.image.style.zIndex = 2;
    new Effect.Appear(item.image, {afterFinish:show_text});
        
    this.currentItem = item;
  },
  
  hide: function(itemToShow){
    var after_finish = function(){
      this.currentItem.image.style.zIndex = 1;
      new Effect.Fade(this.currentItem.image);
      this.currentItem = null;
      this.reveal(itemToShow);
    }.bind(this);
    
    new Effect.Fade(this.currentItem.text, {afterFinish: after_finish, duration:0.5});
  }
}

/*
Event.observe(window, 'load', function() {
	
	
	var reveal = function(element, next, duration, delay) {

		return (function(onCompleted) {
			
			if(typeof(delay) == 'undefined') { delay = 0; }
			
			new Effect.Appear(element, {
				duration: duration,
				
				afterFinish: function() {
					
					if(typeof(onCompleted) == 'function') {
						onCompleted();
					}
					
					setTimeout(next.reveal, delay);
				}.bind(this)
				
			});
			
		});
		
	};
	
	//makes the feature disappear, ready to be shown again
	var reset = function(photograph, quote, button) {
		return (function() {
			Element.hide(photograph);
			Element.hide(quote);
			Element.hide(button);
		});
	};
	
	
	var features = $('intro').getElementsByTagName('a');
	
	var firstFeature = features[0];
	var nextFeature = null;
	var previousFeature = null;
	
	for(var i = 0; i < features.length; i++) {
		
		var feature = features[i];
		var photograph = feature.getElementsByTagName('img')[0];
		var quote = feature.getElementsByTagName('img')[1];
		var button = feature.getElementsByTagName('img')[2];
		
		if(i < features.length-1) {
			nextFeature = features[i+1];
		} else {
			nextFeature = features[0];
		}
		
		if((i-1) >= 0) {
			previousFeature = features[i-1];
		} else {
			previousFeature = features[features.length-1];
		}
		
		//create the chain of elements that will be revealed
		photograph.reveal = reveal(photograph, quote, 3.0, 500);
		quote.reveal = reveal(quote, button, 3.0, 1000);
		button.reveal = reveal(button, nextFeature, 3.0, 2000);
		
		var revealFeature = function(feature, previous, content) {
			return( function() {
				
				//incoming needs to be on top to see its buildin
				Element.setStyle(feature, {zIndex: 10});
				Element.setStyle(previous, {zIndex: 0});
				
				//once the content for this feature has sufficiently
				//loaded to obsucre the backstage, reset the previous
				content.reveal(previous.reset);
			});
		};
		
		feature.reveal = revealFeature(feature, previousFeature, photograph);
		feature.reset = reset(photograph, quote, button);
	}
	
	firstFeature.reveal();
	
});
*/


// Original JS

var oImg = document.createElement('img');


var Intro = {
	iQuoteWidth: 500,
	iQuoteHeight: 332,
	aQuotesHash: new Array(),
	oLens: false,
	oTour: false,
	oQuote: false,
	oMore: false,
		
	init: function() {
		this.oLens = new HTMLObject($('lens'));
		this.oTour = new HTMLObject($('tour'));
		this.oQuote = new HTMLObject($('quote'));
		Object.extend(this.oLens,WhizBang.prototype);
		Object.extend(this.oTour,WhizBang.prototype);
		Object.extend(this.oQuote,WhizBang.prototype);
		this.preloadQuotesHash();
		this.initQuotes();
		var self = this;
		setTimeout(function(){self.oLens.Fade(500,0,100,20,20,20,function(){
			self.oQuote.Fade(500,0,100,30,30,30,function(){
				self.crossfadeQuotes(self);
			});
		});},1000);
		setTimeout(function(){self.oTour.Fade(500,0,100,20,20,20);},1000);
	},
	initQuotes: function() {
		this.oQuote.innerHTML = '';
		var oQuoteImg = oImg.cloneNode(true);
		oQuoteImg.src = this.aQuotesHash[0].src;
		oQuoteImg.alt = this.aQuotesHash[0].alt;
		oQuoteImg.width = this.iQuoteWidth;
		oQuoteImg.height = this.iQuoteHeight;
		this.oQuote.appendChild(oQuoteImg);
		oQuoteImg.style.zIndex = '100';
	},
	preloadQuotesHash: function() {
		if(document.images) {
			for(var i=0, oQuoteImg; oQuoteImg = this.aQuotesHash[i]; i++) {
				var preloadedImg = new Image();
				preloadedImg.src = oQuoteImg.src;
				oQuoteImg.plimg = preloadedImg;
			}
		}
	},
	crossfadeQuotes: function(obj) {
		for(var i=1; i<obj.aQuotesHash.length; i++) {
			var oQuoteImg = oImg.cloneNode(true);
			oQuoteImg.src = obj.aQuotesHash[i].src;
			oQuoteImg.alt = obj.aQuotesHash[i].alt;
			oQuoteImg.width = obj.iQuoteWidth;
			oQuoteImg.height = obj.iQuoteHeight;
			obj.oQuote.appendChild(oQuoteImg);
		}
		var fadeimgs = new HTMLObject(obj.oQuote.getElementsByTagName('img'));
		Object.extend(fadeimgs,WhizBang.prototype);
		fadeimgs.CrossFade();
	}
};
