const express = require('express');
const multer = require('multer');
const cors = require('cors');
const app = express();
const fs = require('fs');
const upload = multer({
dest:'./uploads/' //Upload to server folder
})

app.use(cors());

app.post('/bs/uploads/',upload.single('file'), (req, res) => { // Look for post requests with /upload url , give to multer

        try{
          var oldPath = req.file.path;
          ref = req.get('referer'); // the source domain, needed because of nginx reverse proxy
          var filePath = ref.replace("https://jmpi.ddns.net/bs", "");
          var newPath = '/var/www/html/bs' + filePath + req.file.originalname;
          res.json({file:req.file});  // Return the details of the uploaded file to the browser
          fs.rename(oldPath, newPath, function (err) {
                if (err) throw err
              })
      }catch (err){
        console.error(err);
        res.status(422).json({err});  // Send error 422(Unable to process)
      }
});

app.get('/',function(req,res) {
	res.send('(Upload Something)')
});
app.listen(3000,()=> console.log("Running on localhost:3000"));
