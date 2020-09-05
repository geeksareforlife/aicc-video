/*
  Not a *real* interface, as JS doesn't support them!
  The Provider's service.js file should have all of the below functions
  held in a global Video object attached to the Window

  **This file WILL NOT WORK as a Javascript file**
*/

// loads the video into the given DIV element
Video.embedVideo(videoId, elementID);

// returns a Promise, that when resolved, gives the current position of the video, in seconds
Video.getCurrentPosition();

// returns a Promise, that when resolved, gives the duration of the video, in seconds
Video.getDuration();

// returns a Promise, that when resolved, gives the title of the video
Video.getTitle();