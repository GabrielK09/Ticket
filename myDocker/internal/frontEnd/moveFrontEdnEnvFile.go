package frontEnd

import (
	"log"
	"os"
	"path/filepath"
)

var finalPath string = "D:\\Gabriel\\MVPs\\1\\frontend"

func MoveFile() error {
	// Precisa conferir se no caminho final já tem uma .env com o IP

	existsFileButOtherIp, err := ReadFile()

	if err != nil {
		return err
	}

	if !existsFileButOtherIp {
		currentPath, err := os.Getwd()

		if err != nil {
			log.Fatalf("Erro ao pegar o caminho atual %s", err)
			return err

		}

		log.Println("Vai criar um novo .env com o IP atual")
		fileName, err := CreateFile()

		if err != nil {
			log.Fatalf("Erro ao criar o arquivo %s", err)
			return err

		}

		log.Println("Arquivo criado, vai mover ele para: ", finalPath)

		oldPath := filepath.Join(currentPath, fileName)

		newPath := filepath.Join(finalPath, fileName)

		err = os.Rename(oldPath, newPath)

		if err != nil {
			log.Fatalf("Erro ao mover o arquivo %s", err)
			return err
		}

		log.Println("Arquivo movido")

		log.Printf("Dir: %s", newPath)

		return nil
	} else {
		return nil
	}
}
