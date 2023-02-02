# Control Desk App


### Deploy
https://docs.github.com/en/packages/working-with-a-github-packages-registry/working-with-the-container-registry
- $ export CR_PAT=YOUR_TOKEN
Using the CLI for your container type, sign in to the Container registry service at ghcr.io.

- $ echo $CR_PAT | docker login ghcr.io -u USERNAME --password-stdin
> Login Succeeded

-----
```
cd provisioning
```
```
make authorize
```
```
make docker-login 
```
```
cd ..
```
```
REGISTRY=ghcr.io/audetv IMAGE_TAG=master-1 make build
```
```
REGISTRY=ghcr.io/audetv IMAGE_TAG=master-1 make push
```
```
HOST=deploy@188.68.220.88 PORT=22 REGISTRY=ghcr.io/audetv IMAGE_TAG=master-1 BUILD_NUMBER=1 make deploy
```


Module Auth
-----------
    - Auth
        - Join By Email
            Request
                Command
                Handler
            Confirm
                Command
                Handler

        - Join By Network

        - Attach Network

        - Reset Pasword
            Request
            Confirm

        - Change Email
            Request
            Confirmn
        
        - Change Role

-----------------------

