# INFO2300FinalProject

## How to set up git repository on local machine (i.e. Mac)
1. **In the terminal, type:** 
    ````
    cd <folder where you want to put this project in >
    `````
   >#### For example
   >
   >I did:
   >````
   >cd /Applications/MAMP/htdocs 
   >````
   >Because I use MAMP to view the website.
   
   *Note:* You can drag the folder from the Finder window to the Terminal window and it will copy the folder location to the Terminal, so you don't have to figure out what the absolute location of the folder address is yourself.
   
2. Then type:
    ````
    git clone <git repository url>
    ````
    **In this case, you would type:**
    ````
    git clone https://github.com/myo3/INFO2300FinalProject.git
    ````
    
    *Note:* You can find the git repository url by clicking the green clone or download button and copying the url in the textbox

And that's it!

## Clone Summary
1. `cd` into the folder where you want to put the project in:
   ````
   cd <folder where you want to put this project in>
   ````
2. `clone` the git repository onto your laptop:
    ````
    git clone https://github.com/myo3/INFO2300FinalProject.git
    ````

## How to put your changes onto Github
1. **In terminal `cd` into the project folder:**
    ````
    cd <project folder>
    `````
    
    >#### For example
    >
    >I put the final project in `/Applications/MAMP/htdocs` and the final project is located in a folder called `INFO2300FinalProject` so the address I would `cd` into is:
    >````
    >cd /Applications/MAMP/htdocs/INFO2300FinalProject 
    >`````
    
2. Since this project is a team project it is possible that someone may have updated the master branch (i.e. the branch that holds the main working copy of the project on Github) before you. If that is the case, your copy of our project that you have on your local machine (i.e. laptop) is "behind" because it does not have the latest copy of the project that's on Github. 

    **You can check whether that is the case and also update your local copy by doing:**
    ````
    git pull origin master
    ````
    `origin` is the nickname for the location of your github repository (i.e. `https://github.com/myo3/INFO2300FinalProject.git`) and `master` refers to the main branch. 
    
    So `git pull origin master` is pulling the latest changes from the mater branch of the `INFO2300FinalProject` repository on Github.

3. If you have any merge conflicts Github will tell you. 

   **To see in which files the merge conflicts occur type:**
   ````
   git status
   ````
   Any files labeled `both modified` will have `<<<<<<<<` and `>>>>>>` in the file. Those are markers put in by Github to separate code that's on the Github repository and code that's on your machine that conflicts with the code in the Github repository. 
   
   It is up to you to look at both sets of code and merge them so you only have one copy of that particular chunk of code. 
   
   Don't forget to delete the markers  `<<<<<<<<` and `>>>>>>` when you're done!
   
4. Now you must add your changes. 
   
   **First, see what files have changed:**
   ````
   git status
   ````
   **Add all the files you've changed by typing:**
   ````
   git add <file>
   ````
   **Then commit those changes by doing:**
   ````
   git commit -m "Write message describing the change"
   ````
   The text in between the `"` and `"` are what show up in the [commit history](https://github.com/myo3/INFO2300FinalProject/commits/master "INFO2300FinalProject commit history"). You want write something to describe the changes so other people looking at the commit history can see what you changes you added.
   
   **Then, push your changes to the remote repository on Github:**
   ````
   git push origin master
   ````
   `origin` is the nickname for the location of your github repository (i.e. `https://github.com/myo3/INFO2300FinalProject.git`) and `master` refers to the main branch. 
    
    So `git push origin master` is pushing the changes from your local copy of the project on your laptop to the mater branch of the `INFO2300FinalProject` repository on Github.
    
   >#### For example
   >
   >I created `index.php`, `main.css` in the `css` folder, `main.js` in the `js` folder, and put some images in the `README` folder. 
   >
   >After typing `git status` my terminal says this:
   >
   > <img src="https://github.com/myo3/INFO2300FinalProject/blob/master/README/git%20status.png" width="500">
   >
   >So I `git add` all the files that I created:
   >
   > <img src="https://github.com/myo3/INFO2300FinalProject/blob/master/README/git%20add.png" width="375">
   >
   >Then I `commit` those changes by:
   >
   > <img src="https://github.com/myo3/INFO2300FinalProject/blob/master/README/git%20commit.png" width="700">
   >
   > I finally `push` those changes by doing:
   >
   > <img src="https://github.com/myo3/INFO2300FinalProject/blob/master/README/git%20push.png" width="450">
   >
   > And then my changes are on the github!
   
## Push Summary
1. In terminal `cd` into the project folder:
    ````
    cd <project folder>
    `````
2.  Update your local copy with the copy that's on the Github:
    ````
    git pull origin master
    ````
3. See what files have changed:
   ````
   git status
   ````
4. Add all the files you've changed:
   ````
   git add <file>
   ````
5. Commit those changes:
   ````
   git commit -m "Write message describing the change"
   ````
6. Push your changes to Github:
   ````
   git push origin master
   ````
