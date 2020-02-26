const express = require('express');
const multer = require('multer');
const cors = require('cors');
const app = express();
const upload = multer({
dest:'./uploads/' //Upload to server folder
})

app.use(cors());

app.post('/bs/uploads/',upload.single('file'), (req, res) => { // Look for post requests with /upload url , give to multer

        try{
          console.log(req.originalUrl);

          res.json({file:req.file});  // Return the details of the uploaded file to the browser
      }catch (err){
        res.status(422).json({err});  // Send error 422(Unable to process)
      }
});

app.get('/',function(req,res) {
	res.send('(Upload Something)')
});
app.listen(3000,()=> console.log("Running on localhost:3000"));
