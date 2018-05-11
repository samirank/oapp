for initialization git

git init

git remote add origin https://github.com/samirank/oapp.git

$ git config --global user.email "[email address]"
$ git config --global user.name "[name]"

git add .
git commit -m "comit details"

git pull

git checkout origin master

git marge/master

git push -u origin master

TO OVERWRITE FILE<
https://stackoverflow.com/questions/14318234/how-do-i-ignore-an-error-on-git-pull-about-my-local-changes-would-be-overwritt

git checkout HEAD^ (filename)
git pull
>

TO CHANGE BRANCH TO MASTER <
git checkout -b master 
>
TO VIEW CHANGE LOG <
git log 
git log -1
>
The most commonly used git commands are:
   add        Add file contents to the index
   bisect     Find by binary search the change that introduced a bug
   branch     List, create, or delete branches
   checkout   Checkout a branch or paths to the working tree
   clone      Clone a repository into a new directory
   commit     Record changes to the repository
   diff       Show changes between commits, commit and working tree, etc
   fetch      Download objects and refs from another repository
   grep       Print lines matching a pattern
   init       Create an empty git repository or reinitialize an existing one
   log        Show commit logs
   merge      Join two or more development histories together
   mv         Move or rename a file, a directory, or a symlink
   pull       Fetch from and merge with another repository or a local branch
   push       Update remote refs along with associated objects
   rebase     Forward-port local commits to the updated upstream head
   reset      Reset current HEAD to the specified state
   rm         Remove files from the working tree and from the index
   show       Show various types of objects
   status     Show the working tree status
   tag        Create, list, delete or verify a tag object signed with GPG

See 'git help <command>' for more information on a specific command.